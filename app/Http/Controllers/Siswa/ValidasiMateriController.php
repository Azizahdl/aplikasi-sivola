<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\RiwayatLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ValidasiMateriController extends Controller
{
    /**
     * Terima audio dari frontend, teruskan ke Python (FastAPI),
     * bandingkan skor vs threshold, simpan ke riwayat_latihan, balik JSON.
     *
     * REVISI:
     * - Tambah validasi & normalisasi threshold dari DB (0–1)
     * - Tambah pengecekan skor dari Python (0–1)
     * - Log lengkap untuk debugging
     * - Pesan error lebih informatif
     * - Handle kasus shape mismatch dari Python
     */
    public function validasi(Request $request)
    {
        // ── 1. Validasi Input ────────────────────────────────────────
        $request->validate([
            'audio'       => ['required', 'file', 'mimes:webm,ogg,wav,mp3,mp4', 'max:20480'],
            'id_materi'   => ['required', 'exists:materi,id_materi'],
            'teks_bacaan' => ['required', 'string'],
        ]);

        // ── 2. Ambil Data Materi ─────────────────────────────────────
        $materi = Materi::findOrFail($request->id_materi);

        // Cek vektor referensi tersedia
        if (empty($materi->vektor_referensi)) {
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Vektor referensi belum tersedia. Hubungi Guru!'
            ], 400);
        }

        // ── 3. Normalisasi Threshold dari Database ───────────────────
        //
        // PENTING: Pastikan threshold di DB tersimpan sebagai 0.85 (bukan 85).
        // Blok ini otomatis mengoreksi jika nilai tersimpan dalam skala 0–100.
        //
        $threshold = (float) $materi->threshold;

        if ($threshold > 1) {
            // Kemungkinan tersimpan dalam skala 0–100 (mis. 85), konversi ke 0–1
            $threshold = $threshold / 100;
            Log::warning('Threshold materi ID ' . $materi->id_materi .
                ' tersimpan dalam skala 0-100 (' . $materi->threshold .
                '), otomatis dikonversi ke ' . $threshold .
                '. Sebaiknya update nilai di database menjadi ' . $threshold . '.'
            );
        }

        // Fallback threshold default jika 0 atau tidak diset
        if ($threshold <= 0) {
            $threshold = 0.85;
            Log::warning('Threshold materi ID ' . $materi->id_materi .
                ' bernilai 0 atau kosong. Menggunakan threshold default 0.85.'
            );
        }

        // ── 4. Simpan Audio Sementara ────────────────────────────────
        $audioFile = $request->file('audio');
        $tempPath  = $audioFile->store('temp_audio', 'local');
        $fullPath  = storage_path('app/' . $tempPath);

        try {
            // ── 5. Kirim ke FastAPI Python ────────────────────────────
            Log::info('=== VALIDASI SUARA: MULAI ===');
            Log::info('ID Materi    : ' . $materi->id_materi);
            Log::info('Nama Materi  : ' . $materi->nama_materi ?? '-');
            Log::info('Threshold    : ' . $threshold);
            Log::info('Format Audio : ' . $audioFile->getClientOriginalExtension());
            Log::info('Ukuran Audio : ' . $audioFile->getSize() . ' bytes');

            $response = Http::timeout(60)
                ->attach(
                    'audio_siswa',
                    file_get_contents($fullPath),
                    $audioFile->getClientOriginalName() // Kirim nama asli agar Python tahu ekstensinya
                )
                ->post(config('services.ai_api.url') . '/api/v1/validasi-suara', [
                    'vektor_referensi' => $materi->vektor_referensi
                ]);

            // ── 6. Proses Respons dari Python ─────────────────────────
            if ($response->successful()) {
                $hasilAi = $response->json();

                Log::info('Respons Python  : ' . json_encode($hasilAi));

                // Cek status dari Python
                if (!isset($hasilAi['status']) || $hasilAi['status'] !== 'success') {
                    $pesanError = $hasilAi['message'] ?? 'Tidak ada pesan error dari AI.';
                    Log::error('Python mengembalikan error: ' . $pesanError);
                    return response()->json([
                        'status' => 'error',
                        'pesan'  => 'Error dari AI: ' . $pesanError
                    ], 400);
                }

                // Ambil skor dan pastikan dalam skala 0–1
                $skor_siswa = (float) ($hasilAi['skor_similarity'] ?? 0);

                if ($skor_siswa > 1) {
                    // Jika Python mengirim skala 0–100 (antisipasi)
                    $skor_siswa = $skor_siswa / 100;
                }

                // Clamp nilai antara 0 dan 1
                $skor_siswa = max(0.0, min(1.0, $skor_siswa));

                // ── 7. Tentukan Benar / Salah ──────────────────────────
                $is_benar       = $skor_siswa >= $threshold;
                $statusValidasi = $is_benar ? 'Benar' : 'Salah';

                Log::info('Skor Siswa   : ' . $skor_siswa);
                Log::info('Threshold    : ' . $threshold);
                Log::info('Hasil        : ' . $statusValidasi);
                Log::info('=== VALIDASI SELESAI ===');

                // ── 8. Simpan ke Riwayat Latihan ───────────────────────
                RiwayatLatihan::create([
                    'id_siswa'        => Auth::id(),
                    'id_materi'       => $materi->id_materi,
                    'teks_bacaan'     => $materi->teks_bacaan,
                    'skor_similarity' => $skor_siswa,
                    'status_validasi' => $statusValidasi,
                ]);

                // ── 9. Kembalikan JSON ke Frontend ─────────────────────
                //
                // Skor dikalikan 100 untuk ditampilkan sebagai persentase di animasi JS
                //
                return response()->json([
                    'status'    => $is_benar ? 'benar' : 'salah',
                    'skor'      => round($skor_siswa * 100, 2),
                    'threshold' => round($threshold * 100, 2),
                    'pesan'     => $is_benar
                        ? 'Hebat! Pelafalanmu sudah benar.'
                        : 'Kurang tepat, coba lagi ya!',
                ]);

            } else {
                Log::error('Gagal terhubung ke Python. HTTP Status: ' . $response->status());
                Log::error('Body: ' . $response->body());

                return response()->json([
                    'status' => 'error',
                    'pesan'  => 'Gagal terhubung ke Server AI. Pastikan server Python sedang berjalan.'
                ], 500);
            }

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Connection error ke Python: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Server AI tidak dapat dihubungi. Pastikan FastAPI berjalan di port 8000.'
            ], 503);

        } catch (\Exception $e) {
            Log::error('Validasi materi exception: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);

        } finally {
            // ── 10. Hapus File Audio Sementara ─────────────────────────
            if (Storage::disk('local')->exists($tempPath)) {
                Storage::disk('local')->delete($tempPath);
                Log::info('File audio temp dihapus: ' . $tempPath);
            }
        }
    }
}