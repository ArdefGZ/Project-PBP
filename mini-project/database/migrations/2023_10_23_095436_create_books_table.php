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
        Schema::create('books', function (Blueprint $table) {
            $table->string('isbn')->primary();
            $table->string('judul');
            $table->int('idkategori');
            $table->string('pengarang');
            $table->string('kota_terbit');
            $table->string('editor');
            $table->int('stok');
            $table->string('file');
            $table->timestamps();
            $table->foreign('idkategori')->references('id')->on('kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
