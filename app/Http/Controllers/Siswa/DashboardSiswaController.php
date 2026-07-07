<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\RiwayatLatihan;
use Carbon\Carbon;
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

        // ===== GRAFIK PERKEMBANGAN MINGGUAN DINAMIS (khusus siswa ini) =====
        $sekarang = now();
        $tahun = $sekarang->year;
        $bulan = $sekarang->month;

        // Jika bulan saat ini adalah Januari s.d Juni (Semester Genap)
        if ($bulan >= 1 && $bulan <= 6) {
            // Menuju UTS Genap (Januari - Maret)
            $awalUTS  = Carbon::create($tahun, 1, 1)->startOfDay();
            $akhirUTS = Carbon::create($tahun, 3, 31)->endOfDay();

            // Menuju UAS Genap (April - Juni)
            $awalUAS  = Carbon::create($tahun, 4, 1)->startOfDay();
            $akhirUAS = Carbon::create($tahun, 6, 30)->endOfDay();
        }
        // Jika bulan saat ini adalah Juli s.d Desember (Semester Ganjil)
        else {
            // Menuju UTS Ganjil (Juli - September)
            $awalUTS  = Carbon::create($tahun, 7, 1)->startOfDay();
            $akhirUTS = Carbon::create($tahun, 9, 30)->endOfDay();

            // Menuju UAS Ganjil (Oktober - Desember)
            $awalUAS  = Carbon::create($tahun, 10, 1)->startOfDay();
            $akhirUAS = Carbon::create($tahun, 12, 31)->endOfDay();
        }

        [$labelMingguUTS, $dataMenujuUTSRaw] = $this->hitungRataSkorMingguan($idSiswa, $awalUTS, $akhirUTS);
        [$labelMingguUAS, $dataMenujuUASRaw] = $this->hitungRataSkorMingguan($idSiswa, $awalUAS, $akhirUAS);

        // Samakan jumlah label & data
        $jumlahMinggu = max(count($labelMingguUTS), count($labelMingguUAS));

        $weeklyLabels = [];
        for ($i = 1; $i <= $jumlahMinggu; $i++) {
            $weeklyLabels[] = 'Minggu ' . $i;
        }

        $dataMenujuUTS = array_pad($dataMenujuUTSRaw, $jumlahMinggu, null);
        $dataMenujuUAS = array_pad($dataMenujuUASRaw, $jumlahMinggu, null);

        return view('pages.siswa.dashboard.index', compact(
            'totalDikerjakan',
            'totalMateri',
            'totalBenar',
            'totalSalah',
            'totalLatihan',
            'skorRata',
            'progressKategori',
            'riwayatTerbaru',
            'weeklyLabels',
            'dataMenujuUTS',
            'dataMenujuUAS',
        ));
    }

    /**
     * Hitung rata-rata skor_similarity (dalam %) per minggu, dari $awal sampai $akhir,
     * KHUSUS milik siswa dengan id $idSiswa.
     * Mengembalikan [labels, data] dengan jumlah elemen yang sama.
     */
    private function hitungRataSkorMingguan(int $idSiswa, Carbon $awal, Carbon $akhir): array
    {
        $labels = [];
        $data   = [];

        $cursor   = $awal->copy();
        $mingguKe = 1;

        while ($cursor->lt($akhir)) {
            $akhirMinggu = $cursor->copy()->addWeek();
            if ($akhirMinggu->gt($akhir)) {
                $akhirMinggu = $akhir->copy();
            }

            $rata = RiwayatLatihan::where('id_siswa', $idSiswa)
                ->whereBetween('created_at', [$cursor, $akhirMinggu])
                ->avg('skor_similarity');

            $labels[] = 'Minggu ' . $mingguKe;
            $data[]   = $rata ? round($rata * 100, 1) : 0;

            $cursor->addWeek();
            $mingguKe++;
        }

        return [$labels, $data];
    }
}