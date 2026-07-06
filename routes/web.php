<?php

use App\Http\Controllers\Guru\DashboardGuruController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\DaftarSiswaController;
use App\Http\Controllers\Guru\RiwayatLatihanController;
use App\Http\Controllers\Guru\ManajemenUserController;
use App\Http\Controllers\Siswa\DashboardSiswaController;
use App\Http\Controllers\Siswa\MateriSiswaController;
use App\Http\Controllers\Siswa\ValidasiMateriController;
use App\Http\Controllers\Siswa\SiswaRiwayatLatihanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    // 1. Cek apakah user SUDAH login
    if (auth()->check()) {
        // 2. Jika sudah, cek role-nya apa dan arahkan ke dashboard masing-masing
        if (auth()->user()->role === 'guru') {
            return redirect()->route('guru.dashboard');
        } elseif (auth()->user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard'); 
        }
    }
    
    // 3. Jika BELUM login, baru suruh ke halaman login
    return redirect()->route('login');
});

//ROLE GURU
Route::prefix('guru')->middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard', [DashboardGuruController::class, 'index'])->name('guru.dashboard');
    //Kelola Materi
    Route::get('/materi', [MateriController::class, 'index'])->name('guru.materi.index');
    // Route::get('/materi/create', [MateriController::class, 'create'])->name('guru.materi.create');
    Route::post('/materi', [MateriController::class, 'store'])->name('guru.materi.store');
    Route::get('/materi/{id}/edit', [MateriController::class, 'edit'])->name('guru.materi.edit');
    Route::put('/materi/{id}', [MateriController::class, 'update'])->name('guru.materi.update');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('guru.materi.destroy');
    Route::post('/materi/simpan-referensi', [MateriController::class, 'simpanReferensi'])->name('guru.materi.simpan-referensi');

    //Daftar Siswa
    Route::get('/daftar-siswa', [DaftarSiswaController::class, 'index'])->name('guru.daftar-siswa');
    Route::get('/daftar-siswa/export', [DaftarSiswaController::class, 'export'])->name('guru.daftar-siswa.export');
    Route::post('/daftar-siswa/import', [DaftarSiswaController::class, 'import'])->name('guru.daftar-siswa.import');
    Route::get('/daftar-siswa/template', [DaftarSiswaController::class, 'template'])->name('guru.daftar-siswa.template');

    //Riwayat Latihan
    Route::get('/riwayat-latihan', [RiwayatLatihanController::class, 'index'])->name('guru.riwayat-latihan');
    Route::get('/riwayat-latihan/export', [RiwayatLatihanController::class, 'export'])->name('guru.riwayat-latihan.export');

    //Kelola User
    Route::get('/manajemen-user', [ManajemenUserController::class, 'index'])->name('guru.manajemen-user.index');
    Route::get('/manajemen-user/create', [ManajemenUserController::class, 'create'])->name('guru.manajemen-user.create');
    Route::post('/manajemen-user', [ManajemenUserController::class, 'store'])->name('guru.manajemen-user.store');
    Route::get('/manajemen-user/{id}', [ManajemenUserController::class, 'show'])->name('guru.manajemen-user.show');
    Route::get('/manajemen-user/{id}/edit', [ManajemenUserController::class, 'edit'])->name('guru.manajemen-user.edit');
    Route::put('/manajemen-user/{id}', [ManajemenUserController::class, 'update'])->name('guru.manajemen-user.update');
    Route::delete('/manajemen-user/{id}', [ManajemenUserController::class, 'destroy'])->name('guru.manajemen-user.destroy');
});

//ROLE SISWA
Route::prefix('siswa')->middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard', [DashboardSiswaController::class, 'index'])->name('siswa.dashboard');
    
    //Materi
    Route::get('/materi', [MateriSiswaController::class, 'index'])->name('siswa.materi.index');
    Route::get('/materi/kategori/{kategori}', [MateriSiswaController::class, 'kategori'])->name('siswa.materi.kategori');
    Route::get('/materi/{id}', [MateriSiswaController::class, 'show'])->name('siswa.materi.show');

    //Validasi
    Route::post('/materi/validasi', [ValidasiMateriController::class, 'validasi'])->name('siswa.materi.validasi');

    //Riwayat Latihan Siswa
    Route::get('/riwayat-latihan', [SiswaRiwayatLatihanController::class, 'index'])->name('siswa.riwayat-latihan');
});

require __DIR__.'/auth.php';
