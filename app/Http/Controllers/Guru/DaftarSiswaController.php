<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Imports\DaftarSiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DaftarSiswaExport;
use App\Exports\DaftarSiswaTemplateExport;
use Illuminate\Http\Request;


class DaftarSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data siswa beserta akun user-nya (email, dll)
        $query = Siswa::with('user')
            ->whereHas('user', fn ($q) => $q->where('role', 'siswa'));

        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
            session(['siswa_per_page' => $perPage]);
        } else {
            $perPage = session('siswa_per_page', 10);
        }

        // Fitur Pencarian (nama, NIS, NISN dari tabel siswas; email dari tabel users)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('email', 'like', "%{$search}%");
                  });
            });
        }

        $siswa = $query->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.guru.daftar-siswa.index', compact('siswa'));
    }

    public function export(Request $request)
    {
        $search = $request->search;

        return Excel::download(new DaftarSiswaExport($search), 'data_siswa.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:2048', // maks 2MB
            ],
        ], [
            'file_excel.required' => 'File Excel wajib dipilih.',
            'file_excel.mimes'    => 'Format file harus .xlsx, .xls, atau .csv.',
            'file_excel.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            $import = new DaftarSiswaImport();
            Excel::import($import, $request->file('file_excel'));

            $msg = "Berhasil mengimpor {$import->importedCount} siswa.";
            if ($import->skippedCount > 0) {
                $msg .= " {$import->skippedCount} data dilewati (NIS/NISN/email sudah terdaftar atau baris kosong).";
            }

            return redirect()->route('guru.daftar-siswa')
                ->with('success', $msg);

        } catch (\Exception $e) {
            return redirect()->route('guru.daftar-siswa')
                ->with('error', 'Gagal mengimpor: ' . $e->getMessage());
        }
    }

    public function template()
    {
        return Excel::download(new DaftarSiswaTemplateExport, 'format_import_siswa.xlsx');
    }

}