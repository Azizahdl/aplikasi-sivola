<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class MateriController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->get('search');
        $kategori = $request->get('kategori');

        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
            session(['materi_per_page' => $perPage]);
        } else {
            $perPage = session('materi_per_page', 10);
        }

        $query = Materi::query();

        if ($search) {
            $query->where('teks_bacaan', 'like', "%$search%");
        }
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $materi = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('pages.guru.materi.index', compact('materi'));
    }

    public function create()
    {
        return view('pages.guru.materi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'teks_bacaan' => 'required|string|unique:materi,teks_bacaan',
            'kategori'    => 'required|string|max:255',
        ]);

        $materi = Materi::create([
            'id_guru'     => auth()->id(),
            'teks_bacaan' => $request->teks_bacaan,
            'kategori'    => $request->kategori,
            'threshold'   => 0.85,
        ]);

        return redirect()
            ->route('guru.materi.index')
            ->with('success', 'Materi berhasil ditambahkan!')
            ->with('new_materi_id',   $materi->id_materi)
            ->with('new_materi_teks', $materi->teks_bacaan);
    }

    public function edit($id)
    {
        $materi = Schema::hasColumn('materi', 'id_materi')
            ? Materi::where('id_materi', $id)->firstOrFail()
            : Materi::findOrFail($id);

        return view('pages.guru.materi.edit', compact('materi'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $request->validate([
            'teks_bacaan' => 'required|string|unique:materi,teks_bacaan,' . $id . ',id_materi',
            'kategori'    => 'required|in:abjad,suku_kata,kata_dasar',
            'threshold'   => 'required|numeric|min:0|max:1',
        ]);

        $materi->update([
            'teks_bacaan' => $request->teks_bacaan,
            'kategori'    => $request->kategori,
            'threshold'   => $request->threshold,
        ]);

        return redirect()->route('guru.materi.index')
                         ->with('success', 'Materi berhasil diperbarui!');
    }

    public function simpanReferensi(Request $request)
    {
        $request->validate([
            'audio'     => ['required', 'file', 'mimes:webm,ogg,wav,mp4', 'max:20480'],
            'id_materi' => ['required', 'exists:materi,id_materi'],
        ]);

        $materi   = Materi::findOrFail($request->id_materi);
        $tempPath = $request->file('audio')->store('temp_referensi', 'local');
        $fullPath = storage_path('app/' . $tempPath);

        try {
            // ── Kirim audio ke Python untuk ekstraksi vektor ──────────
            $pythonUrl = config('services.ai_api.url') . '/simpan-referensi';

            Log::info('Mengirim referensi ke Python', [
                'id_materi' => $materi->id_materi,
                'teks'      => $materi->teks_bacaan,
                'url'       => $pythonUrl,
            ]);

            $response = Http::timeout(60)
                ->attach('audio', file_get_contents($fullPath), basename($fullPath))
                ->post($pythonUrl, [
                    'id_materi'      => $materi->id_materi,
                    'teks_referensi' => $materi->teks_bacaan,
                ]);

            if (! $response->successful()) {
                Log::error('Python simpan referensi error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return response()->json([
                    'status' => 'error',
                    'pesan'  => 'Gagal mengirim ke server Python. Coba lagi.',
                ], 502);
            }

            $data = $response->json();

            // ── Validasi response Python mengandung vektor ────────────
            if (empty($data['vektor'])) {
                Log::error('Response Python tidak mengandung vektor', ['data' => $data]);
                return response()->json([
                    'status' => 'error',
                    'pesan'  => 'Server Python tidak mengembalikan vektor. Coba lagi.',
                ], 500);
            }

            // ── Simpan vektor ke kolom vektor_referensi di database ───
            $materi->update([
                'vektor_referensi' => json_encode($data['vektor']),
            ]);

            Log::info('Vektor referensi berhasil disimpan ke DB', [
                'id_materi'    => $materi->id_materi,
                'teks_bacaan'  => $materi->teks_bacaan,
                'panjang_vektor' => count($data['vektor']),
            ]);

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            Log::error('simpanReferensi exception', ['message' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'pesan'  => 'Terjadi kesalahan pada server.',
            ], 500);
        } finally {
            Storage::disk('local')->delete($tempPath);
        }
    }

    public function destroy($id)
    {
        $materi = Schema::hasColumn('materi', 'id_materi')
            ? Materi::where('id_materi', $id)->firstOrFail()
            : Materi::findOrFail($id);

        $materi->delete();

        return redirect()->route('guru.materi.index')
                         ->with('success', 'Materi berhasil dihapus!');
    }
}