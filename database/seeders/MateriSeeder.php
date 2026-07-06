<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class MateriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // PENTING: Pastikan ada user dengan ID ini di tabel 'users'
        $idGuru = 1; 

        // 1. Data Abjad (Sudah satu-satu)
        $abjad = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

        // 2. Data Suku Kata (Benar-benar ditulis satu per satu)
        $sukuKata = [
            'ba', 'bi', 'bu', 'be', 'bo',
            'ca', 'ci', 'cu', 'ce', 'co',
            'da', 'di', 'du', 'de', 'do',
            'fa', 'fi', 'fu', 'fe', 'fo',
            'ga', 'gi', 'gu', 'ge', 'go',
            'ha', 'hi', 'hu', 'he', 'ho',
            'ja', 'ji', 'ju', 'je', 'jo',
            'ka', 'ki', 'ku', 'ke', 'ko',
            'la', 'li', 'lu', 'le', 'lo',
            'ma', 'mi', 'mu', 'me', 'mo',
            'na', 'ni', 'nu', 'ne', 'no',
            'pa', 'pi', 'pu', 'pe', 'po',
            'ra', 'ri', 'ru', 're', 'ro',
            'sa', 'si', 'su', 'se', 'so',
            'ta', 'ti', 'tu', 'te', 'to',
            'wa', 'wi', 'wu', 'we', 'wo',
            'ya', 'yi', 'yu', 'ye', 'yo',
            'za', 'zi', 'zu', 'ze', 'zo'
        ];

        // 3. Data Kata Dasar (Sudah satu-satu)
        $kataDasar = [
            'Buku', 'Bola', 'Baju', 'Kaki', 'Kuku', 'Kaca', 'Kayu', 'Mata', 'Meja', 
            'Mama', 'Susu', 'Sapi', 'Satu', 'Lima', 'Roti', 'Baca', 'Tulis', 'Jalan', 
            'Lari', 'Duduk', 'Tidur', 'Masak', 'Mandi', 'Cuci', 'Buka', 'Tutup'
        ];

        $insertData = [];

        // --- Proses Data Abjad ---
        foreach ($abjad as $item) {
            $insertData[] = [
                'teks_bacaan' => trim($item),
                'kategori' => 'Abjad', 
                'vektor_referensi' => null,
                'threshold' => 0.85, 
                'id_guru' => $idGuru,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // --- Proses Data Suku Kata ---
        foreach ($sukuKata as $item) {
            $insertData[] = [
                'teks_bacaan' => trim($item),
                'kategori' => 'suku_kata', 
                'vektor_referensi' => null,
                'threshold' => 0.85,
                'id_guru' => $idGuru,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // --- Proses Data Kata Dasar ---
        foreach ($kataDasar as $item) {
            $insertData[] = [
                'teks_bacaan' => trim($item),
                'kategori' => 'kata_dasar', 
                'vektor_referensi' => null,
                'threshold' => 0.85,
                'id_guru' => $idGuru,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Insert semua data sekaligus ke database
        DB::table('materi')->insert($insertData);
    }
}
