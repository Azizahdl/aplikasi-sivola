<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class DaftarSiswaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    public int $importedCount = 0;
    public int $skippedCount  = 0;

    /**
     * Mengatur agar Laravel Excel membaca baris ke-4 sebagai Heading Row
     */
    public function headingRow(): int
    {
        return 4;
    }

    public function model(array $row)
    {
        // 1. Cek validasi data wajib terlebih dahulu
        if (empty($row['nama']) || empty($row['email']) || empty($row['nis'])) {
            $this->skippedCount++;
            return null;
        }

        // 2. Cek apakah email atau nis sudah terdaftar di sistem
        $emailExists = User::where('email', trim($row['email']))->exists();
        $nisExists   = Siswa::where('nis', trim($row['nis']))->exists();

        if ($emailExists || $nisExists) {
            $this->skippedCount++;
            return null;
        }

        // 3. PROSES PEMBUATAN USER (AKUN)
        $user = User::create([
            'nama'        => trim($row['nama']),
            'email'       => trim($row['email']),
            'password'    => Hash::make('password'), // password default
            'role'        => 'siswa',
            'status_akun' => 'aktif',
        ]);

        // Konversi tanggal lahir dari Excel dengan aman
        $tanggalLahir = null;
        if (!empty($row['tanggal_lahir'])) {
            try {
                // Jika formatnya angka/serial Excel
                if (is_numeric($row['tanggal_lahir'])) {
                    $tanggalLahir = Carbon::instance(Date::excelToDateTimeObject($row['tanggal_lahir']))->format('Y-m-d');
                } else {
                    // Jika formatnya string teks biasa (misal: 19-01-2020)
                    $tanggalLahir = Carbon::parse($row['tanggal_lahir'])->format('Y-m-d');
                }
            } catch (\Exception $e) {
                $tanggalLahir = now()->format('Y-m-d'); // fallback jika error parsing
            }
        }

        // Pemetaan jenis kelamin sesuai enum DB ('L' atau 'P')
        $jk = 'L';
        if (!empty($row['jenis_kelamin'])) {
            $jkText = strtolower(trim($row['jenis_kelamin']));
            if ($jkText === 'perempuan' || $jkText === 'p') {
                $jk = 'P';
            }
        }

        // 4. PROSES PEMBUATAN DATA SISWA (Terhubung lewat user_id)
        Siswa::create([
            'user_id'       => $user->id, 
            'nama'          => trim($row['nama']),
            'nis'           => trim($row['nis']),
            'nisn'          => !empty($row['nisn']) ? trim($row['nisn']) : null,
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $jk,
        ]);

        $this->importedCount++;

        // Return null karena kita sudah melakukan insert manual (create) secara berurutan di atas
        return null; 
    }
}