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
        Schema::table('users', function (Blueprint $table) {
            // Perintah untuk menghapus kolom nomor_induk
            $table->dropColumn('nomor_induk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Jika migrasi dibatalkan (rollback), kolom nomor_induk akan dibuat kembali
            $table->string('nomor_induk')->nullable();
        });
    }
};
