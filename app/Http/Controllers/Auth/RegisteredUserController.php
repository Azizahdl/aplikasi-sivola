<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa; // <--- PASTIKAN UNTUK IMPORT MODEL SISWA DI SINI
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDASI DATA FORM (Sesuaikan dengan kolom tabel siswa kamu)
        $request->validate([
            'nama'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'nis'           => ['required', 'string', 'max:50', 'unique:'.Siswa::class], // Validasi NIS harus unik di tabel siswa
            'nisn'          => ['nullable', 'string', 'max:50', 'unique:'.Siswa::class], // Validasi NISN harus unik
            'tanggal_lahir' => ['required', 'date'],
            'jenis_kelamin' => ['required', 'in:L,P'], // Hanya menerima L atau P
        ]);

        // 2. INSERT KE TABEL USERS (Buat akun login)
        $user = User::create([
            'nama'        => $request->nama,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'siswa', // Otomatis set role sebagai siswa
            'status_akun' => 'aktif',
        ]);

        // 3. INSERT KE TABEL SISWAS (Otomatis masuk ke daftar siswa)
        Siswa::create([
            'user_id'       => $user->id, // Mengambil ID user yang baru saja disimpan di atas
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'nisn'          => $request->nisn,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
        ]);

        event(new Registered($user));

        // Auth::login($user); // Tetap di-comment sesuai bawaan kodinganmu sebelumnya

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login menggunakan akun Anda.');
    }
}