<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatLatihan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_latihan';
    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_siswa',
        'id_materi',
        'teks_bacaan',
        'skor_similarity',
        'status_validasi',
    ];

    // Relasi ke tabel users (Siswa)
    public function siswa()
    {
        return $this->belongsTo(User::class, 'id_siswa', 'id');
    }

    // Relasi ke tabel materi
    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi', 'id_materi');
    }
}