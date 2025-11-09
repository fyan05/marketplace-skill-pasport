<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use App\Models\TokoController; // kalau ini model toko kamu
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // 🟢 STATISTIK UTAMA
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $totalToko = TokoController::count();

        // 🟡 DATA GRAFIK: Ambil kategori dan hitung jumlah produk per kategori
        $kategori = Kategori::withCount('produk')->get();
        $namaKategori = $kategori->pluck('nama_kategori');       // label untuk grafik
        $jumlahProdukPerKategori = $kategori->pluck('produk_count'); // data jumlah per kategori

        // 🟢 PRODUK TERBARU (5 produk terakhir)
        $produkTerbaru = Produk::orderBy('tanggal_upload', 'desc')->take(5)->get();

        // 🟠 PRODUK DENGAN STOK TERTINGGI & TERENDAH
        $produkStokTinggi = Produk::orderByDesc('stok')->first();
        $produkStokRendah = Produk::orderBy('stok')->first();

        // 🔴 PRODUK DENGAN STOK RENDAH (stok <= 5)
        $produkStokRendahList = Produk::where('stok', '<=', 5)->get();

        // 🔵 KIRIM SEMUA DATA KE VIEW
        return view('admin.dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalUser',
            'totalToko',
            'namaKategori',
            'jumlahProdukPerKategori',
            'produkTerbaru',
            'produkStokTinggi',
            'produkStokRendah',
            'produkStokRendahList'
        ));
    }
}
