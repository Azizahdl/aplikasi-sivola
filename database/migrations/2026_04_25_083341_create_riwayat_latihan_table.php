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
        Schema::create('riwayat_latihan', function (Blueprint $table) {
            // Primary Key
            $table->id('id_riwayat');

            // Foreign Key ke tabel users (Siswa)
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_siswa')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_materi');
            $table->foreign('id_materi')->references('id_materi')->on('materi')->onDelete('cascade');
            $table->float('skor_similarity');
            $table->enum('status_validasi', ['Benar', 'Salah']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_latihan');
    }
};