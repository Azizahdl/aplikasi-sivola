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
        Schema::table('riwayat_latihan', function (Blueprint $table) {
           $table->text('teks_bacaan')->after('id_materi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_latihan', function (Blueprint $table) {
           $table->dropColumn('teks_bacaan');
        });
    }
};
