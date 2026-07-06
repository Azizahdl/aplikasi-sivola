<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DaftarSiswaExport implements FromView, ShouldAutoSize
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function view(): View
    {
        $query = User::where('role', 'siswa');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', "%{$this->search}%")
                  ->orWhere('nomor_induk', 'like', "%{$this->search}%");
            });
        }

        return view('pages.guru.daftar-siswa.export', [
            'siswa' => $query->get()
        ]);
    }
}