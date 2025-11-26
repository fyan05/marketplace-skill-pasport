<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\toko;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    //
    public function index()
    {
        $produk = produk::with('gambarProduks')->orderBy('id', 'desc')->get()->take(8);
        return view('pengguna.home' , compact('produk'));
    }
    public function produk(Request $request)
    {
         $kategori = $request->kategori;

         $produk = Produk::with('gambarProduks')
        ->when($kategori, function ($q) use ($kategori) {
            return $q->where('id_kategori', $kategori);
        })
        ->orderBy('id', 'desc')
        ->get();

    return view('pengguna.produk', compact('produk', 'kategori'));
    }

    public function toko($id)
    {
    $toko = toko::findOrFail($id);
    $produk = Produk::where('id_toko', $id)->get();

        return view('pengguna.toko', compact('toko', 'produk'));
    }
    public function kategori($id)
    {
        return view('pengguna.kategori', compact('id'));
    }
    public function detailproduk($id)
    {
     $produk = Produk::with('gambarProduks')->findOrFail($id);

    // Urutkan gambar dari yang terbaru
    $produk->gambarProduks = $produk->gambarProduks->sortByDesc('id')->values();

        return view('pengguna.detail-produk', compact('produk'));
    }
    public function cari(Request $request)
{
   $q = $request->q;

    // Cari Produk + relasi kategori + relasi toko
    $produk = Produk::with(['kategori', 'toko'])
        ->where('nama_produk', 'like', "%$q%")
        ->orWhereHas('kategori', function ($kat) use ($q) {
            $kat->where('nama_kategori', 'like', "%$q%");
        })
        ->get();
    $toko = toko::where('nama_toko','like',"%$q%")
        ->get();

    return view('pengguna.search', compact('produk', 'q','toko'));
}

}
