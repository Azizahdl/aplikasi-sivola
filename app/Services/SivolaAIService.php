<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;

class SivolaAIService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.ai_api.url');
    }

    // ============================================================
    // 1. SIMPAN REFERENSI GURU
    //    Kirim audio guru → dapat vektor → simpan ke DB
    // ============================================================
    public function simpanReferensiGuru(
        UploadedFile $audio,
        string $idMateri,
        string $teksReferensi
    ): array {
        $response = Http::timeout(120)
            ->attach('audio', file_get_contents($audio->path()), $audio->getClientOriginalName())
            ->post("{$this->baseUrl}/simpan-referensi", [
                'id_materi'       => $idMateri,
                'teks_referensi'  => $teksReferensi,
            ]);

        if ($response->failed()) {
            throw new \Exception('Gagal menghubungi AI API: ' . $response->body());
        }

        return $response->json();
    }

    // ============================================================
    // 2. VALIDASI SUARA SISWA
    //    Kirim audio siswa + vektor guru → dapat skor similarity
    // ============================================================
    public function validasiSuaraSiswa(
        UploadedFile $audio,
        array $vektorReferensi
    ): array {
        $response = Http::timeout(120)
            ->attach('audio_siswa', file_get_contents($audio->path()), $audio->getClientOriginalName())
            ->post("{$this->baseUrl}/api/v1/validasi-suara", [
                'vektor_referensi' => json_encode($vektorReferensi),
            ]);

        if ($response->failed()) {
            throw new \Exception('Gagal menghubungi AI API: ' . $response->body());
        }

        return $response->json();
    }

    // ============================================================
    // 3. HEALTH CHECK
    // ============================================================
    public function healthCheck(): bool
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/health");
            return $response->successful();
        } catch (\Exception) {
            return false;
        }
    }
}