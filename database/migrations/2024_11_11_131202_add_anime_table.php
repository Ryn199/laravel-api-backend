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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('judul');
            $table->String('deskripsi');
            $table->String('sinopsis');
            $table->string('rating');
            $table->timestamps();
        });
    }
    // 'image',
    // 'judul',
    // 'deskripsi',
    // 'sinopsis',
    // 'rating',

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
