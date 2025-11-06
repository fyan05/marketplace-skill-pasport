<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\produk;
use App\Models\TokoController;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
    // Statistik
    $totalProduk = produk::count();
    $totalKategori = Kategori::count();
    $totalUser = User::count();
    $totalToko = TokoController::count();

    // Data untuk grafik
    $kategori = Kategori::withCount('produk')->get();
    $namaKategori = $kategori->pluck('nama_kategori');
    $jumlahProdukPerKategori = $kategori->pluck('produk_count');

    // Produk terbaru
    $produkTerbaru = Produk::orderBy('tanggal_upload', 'desc')->take(5)->get();

    return view('admin.dashboard', compact(
        'totalProduk', 'totalKategori', 'totalUser', 'totalToko',
        'namaKategori', 'jumlahProdukPerKategori', 'produkTerbaru'
    ));
    }
}
