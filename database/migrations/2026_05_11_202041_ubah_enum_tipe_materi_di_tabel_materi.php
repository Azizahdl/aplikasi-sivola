<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ubah struktur enum untuk menampung 'abjad' terlebih dahulu
        DB::statement("ALTER TABLE materi MODIFY COLUMN tipe_materi ENUM('huruf', 'abjad', 'suku_kata', 'kata_dasar') DEFAULT NULL");

        // 2. Update data yang sudah terlanjur tersimpan di database ('huruf' -> 'abjad')
        DB::table('materi')->where('tipe_materi', 'huruf')->update(['tipe_materi' => 'abjad']);

        // 3. Hapus 'huruf' dari struktur enum secara permanen
        DB::statement("ALTER TABLE materi MODIFY COLUMN tipe_materi ENUM('abjad', 'suku_kata', 'kata_dasar') DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
