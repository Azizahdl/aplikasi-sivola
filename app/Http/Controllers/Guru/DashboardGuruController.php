<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RiwayatLatihan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardGuruController extends Controller
{
    public function index()
    {
        $totalSiswa         = User::where('role', 'siswa')->count();
        $totalSiswaAktif    = User::where('role', 'siswa')->where('status_akun', 'aktif')->count();
        $totalSiswaNonaktif = User::where('role', 'siswa')->where('status_akun', 'nonaktif')->count();

        // ===== GRAFIK PERKEMBANGAN MINGGUAN DINAMIS =====
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

        [$labelMingguUTS, $dataMenujuUTSRaw] = $this->hitungRataSkorMingguan($awalUTS, $akhirUTS);
        [$labelMingguUAS, $dataMenujuUASRaw] = $this->hitungRataSkorMingguan($awalUAS, $akhirUAS);

        // Samakan jumlah label & data
        $jumlahMinggu = max(count($labelMingguUTS), count($labelMingguUAS));

        $weeklyLabels = [];
        for ($i = 1; $i <= $jumlahMinggu; $i++) {
            $weeklyLabels[] = 'Minggu ' . $i;
        }

        $dataMenujuUTS = array_pad($dataMenujuUTSRaw, $jumlahMinggu, null);
        $dataMenujuUAS = array_pad($dataMenujuUASRaw, $jumlahMinggu, null);

        // ===== DONUT CHART: HASIL VALIDASI PELAFALAN PER MATERI =====
        $benarAbjad = RiwayatLatihan::whereHas('materi', fn ($q) => $q->where('kategori', 'Abjad'))
            ->where('status_validasi', 'Benar')->count();
        $salahAbjad = RiwayatLatihan::whereHas('materi', fn ($q) => $q->where('kategori', 'Abjad'))
            ->where('status_validasi', 'Salah')->count();

        $benarSukukata = RiwayatLatihan::whereHas('materi', fn ($q) => $q->where('kategori', 'suku_kata'))
            ->where('status_validasi', 'Benar')->count();
        $salahSukukata = RiwayatLatihan::whereHas('materi', fn ($q) => $q->where('kategori', 'suku_kata'))
            ->where('status_validasi', 'Salah')->count();

        $benarKatadasar = RiwayatLatihan::whereHas('materi', fn ($q) => $q->where('kategori', 'kata_dasar'))
            ->where('status_validasi', 'Benar')->count();
        $salahKatadasar = RiwayatLatihan::whereHas('materi', fn ($q) => $q->where('kategori', 'kata_dasar'))
            ->where('status_validasi', 'Salah')->count();

        return view('pages.guru.dashboard.index', compact(
            'totalSiswa',
            'totalSiswaAktif',
            'totalSiswaNonaktif',
            'weeklyLabels',
            'dataMenujuUTS',
            'dataMenujuUAS',
            'benarAbjad',
            'salahAbjad',
            'benarSukukata',
            'salahSukukata',
            'benarKatadasar',
            'salahKatadasar'
        ));
    }

    /**
     * Hitung rata-rata skor_similarity (dalam %) per minggu, dari $awal sampai $akhir.
     * Mengembalikan [labels, data] dengan jumlah elemen yang sama.
     */
    private function hitungRataSkorMingguan(Carbon $awal, Carbon $akhir): array
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

            $rata = RiwayatLatihan::whereBetween('created_at', [$cursor, $akhirMinggu])
                ->avg('skor_similarity');

            $labels[] = 'Minggu ' . $mingguKe;
            $data[]   = $rata ? round($rata * 100, 1) : 0;

            $cursor->addWeek();
            $mingguKe++;
        }

        return [$labels, $data];
    }
}