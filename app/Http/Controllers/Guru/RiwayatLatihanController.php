<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RiwayatLatihan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatLatihanExport;
use Illuminate\Http\Request;

class RiwayatLatihanController extends Controller
{
    public function index(Request $request)
    {
        // Panggil data riwayat latihan beserta relasi siswa dan materi
        // Urutkan dari yang paling baru latihan (latest)
        $query = RiwayatLatihan::with(['siswa', 'materi'])->latest();

        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
            session(['riwayat_per_page' => $perPage]);
        } else {
            $perPage = session('riwayat_per_page', 10);
        }

        // Fitur Pencarian: Bisa cari berdasarkan Nama Siswa atau Teks Materi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('siswa', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%{$search}%"); // Hanya cari nama
                })->orWhereHas('materi', function ($q2) use ($search) {
                    $q2->where('teks_bacaan', 'like', "%{$search}%");
                });
             });
        }

        // Fitur Filter Status (Benar / Salah)
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status_validasi', $request->status);
        }

        // Fitur Filter Tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Pagination
        $riwayat = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('pages.guru.riwayat-latihan.index', compact('riwayat'));
    }

    public function export(Request $request)
    {
        $search   = $request->search;
        $status   = $request->status;
        $dateFrom = $request->date_from;
        $dateTo   = $request->date_to;

        return Excel::download(
            new RiwayatLatihanExport($search, $status, $dateFrom, $dateTo),
            'riwayat_latihan.xlsx'
        );
    }
}