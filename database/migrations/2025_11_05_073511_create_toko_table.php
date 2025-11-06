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
        Schema::create('toko_controllers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_toko');
            $table->text('deskripsi_toko');
            $table->string('gambar');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('kontak_toko');
            $table->string('alamat_toko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko_controllers');
    }
};
