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
        Schema::create('materi', function (Blueprint $table) {
            $table->id('id_materi'); 
            $table->string('teks_bacaan'); 
            $table->enum('tipe_materi', ['huruf', 'suku_kata', 'kata_dasar'])->nullable();
            $table->json('vektor_referensi')->nullable(); 
            $table->float('threshold')->default(0.75); 
            $table->unsignedBigInteger('id_guru'); 
            $table->foreign('id_guru')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};