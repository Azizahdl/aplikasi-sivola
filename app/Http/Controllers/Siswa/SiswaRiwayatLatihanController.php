<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\RiwayatLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaRiwayatLatihanController extends Controller
{
    public function index(Request $request)
    {
        $query = RiwayatLatihan::with('materi')
            ->where('id_siswa', Auth::id());

        // Filter status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_validasi', $request->status);
        }

        // Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->whereHas('materi', fn($q) =>
                $q->where('kategori', $request->kategori)
            );
        }

        // Filter tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search materi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('teks_bacaan', 'like', "%{$search}%")
                  ->orWhereHas('materi', fn($q2) =>
                      $q2->where('teks_bacaan', 'like', "%{$search}%")
                  );
            });
        }

        $query->latest();

        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
            session(['materi_per_page' => $perPage]);
        } else {
            $perPage = session('materi_per_page', 10);
        }
        $riwayat = $query->paginate($perPage)->withQueryString();

        // Stats ringkasan
        $allRiwayat = RiwayatLatihan::where('id_siswa', Auth::id());
        $stats = [
            'total'      => (clone $allRiwayat)->count(),
            'benar'      => (clone $allRiwayat)->where('status_validasi', 'Benar')->count(),
            'salah'      => (clone $allRiwayat)->where('status_validasi', 'Salah')->count(),
            'rata_skor'  => (clone $allRiwayat)->avg('skor_similarity') * 100,
        ];

        return view('pages.siswa.riwayat-latihan.index', compact('riwayat', 'stats'));
    }
}