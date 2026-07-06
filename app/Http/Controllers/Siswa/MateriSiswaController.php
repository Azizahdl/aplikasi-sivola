<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;

class MateriSiswaController extends Controller
{
    // Halaman 1: Pilih Kategori
    public function index()
    {
        return view('pages.siswa.materi.index');
    }
 
    // Halaman 2: List Materi sesuai kategori
    public function kategori($kategori)
    {
        $validKategori = ['Abjad', 'suku_kata', 'kata_dasar'];
 
        if (!in_array($kategori, $validKategori)) {
            return redirect()->route('siswa.materi.index');
        }
 
        $materiList = Materi::where('kategori', $kategori)->get();
 
        return view('pages.siswa.materi.kategori', compact('materiList', 'kategori'));
    }

    public function show($id)
    {
        $materi = Materi::findOrFail($id);
        return view('pages.siswa.materi.show', compact('materi'));
    }

}