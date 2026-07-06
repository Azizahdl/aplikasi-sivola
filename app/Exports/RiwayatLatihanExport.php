<?php

namespace App\Exports;

use App\Models\RiwayatLatihan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RiwayatLatihanExport implements FromView, ShouldAutoSize
{
    protected $search;
    protected $status;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($search = null, $status = null, $dateFrom = null, $dateTo = null)
    {
        $this->search   = $search;
        $this->status   = $status;
        $this->dateFrom = $dateFrom;
        $this->dateTo   = $dateTo;
    }

    public function view(): View
    {
        $query = RiwayatLatihan::with(['siswa', 'materi']);

        // FILTER SEARCH (nama siswa / materi)
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('siswa', function ($s) {
                    $s->where('nama', 'like', "%{$this->search}%");
                })
                ->orWhereHas('materi', function ($m) {
                    $m->where('teks_bacaan', 'like', "%{$this->search}%");
                });
            });
        }

        // FILTER STATUS (Benar / Salah)
        if ($this->status && $this->status !== 'semua') {
            $query->where('status_validasi', $this->status);
        }

        // FILTER TANGGAL
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $query->orderBy('created_at', 'desc');

        return view('pages.guru.riwayat-latihan.export', [
            'riwayat'   => $query->get(),
            'search'    => $this->search,
            'status'    => $this->status,
            'dateFrom'  => $this->dateFrom,
            'dateTo'    => $this->dateTo,
        ]);
    }
}