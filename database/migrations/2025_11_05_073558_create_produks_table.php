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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->references('id')->on('kategoris');
            $table->foreignId('id_toko')->references('id')->on('toko_controllers');
            $table->string('nama_produk');
            $table->text('deskripsi');
            $table->integer('harga');
            $table->integer('stok');
            $table->date('tanggal_upload');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
