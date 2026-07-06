<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManajemenUserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter dari query string
        $role = $request->get('role');
        $status = $request->get('status');
        $search = $request->get('search'); 

        $query = User::query();

        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
            session(['users_per_page' => $perPage]); 
        } else {
            $perPage = session('users_per_page', 10);
        }

        // Filter role
        if ($role) {
            $query->where('role', $role);
        }

        // Filter status akun
        if ($status) {
            $query->where('status_akun', $status);
        }

        // Pencarian nama/email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Pagination dengan per_page
        $users = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('pages.guru.manajemen-user.index', compact('users', 'role', 'status', 'search', 'perPage'));
    }

    public function create()
    {
        return view('pages.guru.manajemen-user.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'nama' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:guru,siswa',
            'password' => 'required|string|min:8|confirmed', 
            'status_akun' => 'required|in:aktif,nonaktif,suspend',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Upload Foto Profile (Jika ada)
        $fotoPath = null;
        if ($request->hasFile('foto_profile')) {
            $fotoPath = $request->file('foto_profile')->store('profile_photos', 'public');
        }

        // 3. Simpan ke Database
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password), 
            'status_akun' => $request->status_akun,
            'foto_profile' => $fotoPath,
        ]);

        return redirect()->route('guru.manajemen-user.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('pages.guru.manajemen-user.show', compact('user'));
    }

    // --- METHOD BARU: EDIT & UPDATE ---
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.guru.manajemen-user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:guru,siswa',
            'status_akun' => 'required|in:aktif,nonaktif,suspend',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_profile')) {
            if ($user->foto_profile && \Storage::disk('public')->exists($user->foto_profile)) {
                \Storage::disk('public')->delete($user->foto_profile);
            }
            $user->foto_profile = $request->file('foto_profile')->store('profile_photos', 'public');
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->status_akun = $request->status_akun;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('guru.manajemen-user.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_akun' => 'required|in:aktif,nonaktif,suspend',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'status_akun' => $request->status_akun
        ]);

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Opsional: Hapus foto profil dari storage sebelum user dihapus
        if ($user->foto_profile && \Storage::disk('public')->exists($user->foto_profile)) {
            \Storage::disk('public')->delete($user->foto_profile);
        }

        $user->delete();

        return redirect()->route('guru.manajemen-user.index')->with('success', 'User berhasil dihapus.');
    }
}