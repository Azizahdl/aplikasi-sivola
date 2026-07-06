<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\RiwayatLatihan;
use Illuminate\Support\Facades\Auth;

class DashboardSiswaController extends Controller
{
    public function index()
    {
        $idSiswa = Auth::id();
 
        // ── Total materi dikerjakan (unik) ───────────────────────────
        $totalDikerjakan = RiwayatLatihan::where('id_siswa', $idSiswa)
            ->distinct('id_materi')
            ->count('id_materi');
 
        // ── Total materi yang tersedia ───────────────────────────────
        $totalMateri = Materi::count();
 
        // ── Jumlah Benar & Salah ─────────────────────────────────────
        $totalBenar = RiwayatLatihan::where('id_siswa', $idSiswa)
            ->where('status_validasi', 'Benar')
            ->count();
 
        $totalSalah = RiwayatLatihan::where('id_siswa', $idSiswa)
            ->where('status_validasi', 'Salah')
            ->count();
 
        $totalLatihan = $totalBenar + $totalSalah;
 
        // ── Skor rata-rata ───────────────────────────────────────────
        $skorRata = RiwayatLatihan::where('id_siswa', $idSiswa)
            ->avg('skor_similarity');
        $skorRata = $skorRata ? round($skorRata * 100, 1) : 0;
 
        // ── Progress per kategori ────────────────────────────────────
        $kategoriList = Materi::select('kategori')
            ->distinct()
            ->pluck('kategori');
 
        $progressKategori = $kategoriList->map(function ($kategori) use ($idSiswa) {
            $totalTipe   = Materi::where('kategori', $kategori)->count();
            $sudahTipe   = RiwayatLatihan::where('id_siswa', $idSiswa)
                ->whereHas('materi', fn($q) => $q->where('kategori', $kategori))
                ->distinct('id_materi')
                ->count('id_materi');
            $persen = $totalTipe > 0 ? round(($sudahTipe / $totalTipe) * 100) : 0;
 
            return [
                'kategori'   => $kategori,
                'label'  => ucfirst(str_replace('_', ' ', $kategori)),
                'selesai'=> $sudahTipe,
                'total'  => $totalTipe,
                'persen' => $persen,
            ];
        });
 
        // ── Riwayat latihan terbaru (5 terakhir) ─────────────────────
        $riwayatTerbaru = RiwayatLatihan::where('id_siswa', $idSiswa)
            ->with('materi')
            ->latest()
            ->take(5)
            ->get();
 
        return view('pages.siswa.dashboard.index', compact(
            'totalDikerjakan',
            'totalMateri',
            'totalBenar',
            'totalSalah',
            'totalLatihan',
            'skorRata',
            'progressKategori',
            'riwayatTerbaru',
        ));
    }
}
