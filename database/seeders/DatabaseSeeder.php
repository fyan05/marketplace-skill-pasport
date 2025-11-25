<?php

namespace Database\Seeders;

use App\Models\gambar_produk;
use App\Models\informasi;
use App\Models\Kategori;
use App\Models\produk;
use App\Models\Toko;
use App\Models\TokoController;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin',
            'username' => 'admin',
            'kontak' => '081234567890',
            'role' => 'admin',
            'password' => bcrypt('123'),
        ]);
        User::create([
            'nama' => 'Rista',
            'username' => 'rista',
            'kontak' => '081234567890',
            'role' => 'member',
            'password' => bcrypt('123'),
        ]);
        Toko::create([
            'nama_toko' => 'Toko Contoh',
            'deskripsi_toko' => 'Ini adalah deskripsi contoh toko.',
            'alamat_toko' => 'Jl. Contoh No. 123',
            'kontak_toko' => '081298765432',
            'status'=>'active',
            'gambar' => 'toko_contoh.jpg',
            'user_id' => 2,
        ]);
        Kategori::create([
            'nama_kategori' => 'Makanan',
        ]);
        Kategori::create([
            'nama_kategori' => 'Minuman',
        ]);
        Kategori::create([
            'nama_kategori' => 'Alat Tulis',
        ]);
        produk::create([
            'nama_produk' => 'Contoh Produk',
            'deskripsi' => 'Ini adalah deskripsi contoh produk.',
            'harga' => 10000,
            'stok' => 50,
            'id_kategori' => 1,
            'id_toko' => 1,
            'tanggal_upload' => now(),
        ]);
        informasi::create([
            'judul' => 'Contoh Informasi',
            'deskripsi' => 'Ini adalah deskripsi contoh informasi.',
            'video' => 'contoh_video.mp4',
        ]);
    }
}
