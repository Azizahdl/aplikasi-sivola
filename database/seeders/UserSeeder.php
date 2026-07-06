<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Guru',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nomor_induk' => '198001012005011001',
            'status_akun' => 'aktif',
        ]);

        User::create([
            'nama' => 'siswa',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'nomor_induk' => '0012345678',
            'status_akun' => 'aktif',
        ]);

    }
}
