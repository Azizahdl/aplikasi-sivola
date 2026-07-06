<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi'; // Nama tabel
    protected $primaryKey = 'id_materi'; // Nama PK

    protected $fillable = [
        'teks_bacaan',
        'kategori',
        'vektor_referensi',
        'threshold',
        'id_guru',
    ];

    // Relasi ke Guru
    public function guru()
    {
        return $this->belongsTo(User::class, 'id_guru', 'id');
    }
}