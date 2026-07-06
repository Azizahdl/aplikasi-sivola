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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            // Menghubungkan siswa ke akun user-nya (Foreign Key)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom data siswa sesuai format sekolah yang kamu minta
            $table->string('nama');
            $table->string('nis')->unique();
            $table->string('nisn')->unique()->nullable(); // nullable jika ada siswa belum punya NISN
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
