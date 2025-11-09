<?php

namespace App\Http\Controllers;

use App\Models\gambar_produk;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\GambarProduk;
use App\Models\TokoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    // 🟢 TAMPIL SEMUA PRODUK
    public function index()
    {
        $produks = Produk::with(['kategori', 'gambarProduks'])->orderBy('id', 'DESC')->get();
        $kategori = Kategori::all();
        $toko =TokoController::all();
        return view('admin.produk', compact('produks', 'kategori', 'toko'));
    }

    // 🟢 SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'id_toko' => 'required',
            'nama_produk' => 'required|max:50',
            'deskripsi' => 'required',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'id_toko' => $request->id_toko,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'tanggal_upload' => now(),
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $namaProduk = str_replace(' ', '_', strtolower($produk->nama_produk));
                $namaFile = $namaProduk . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('produk', $namaFile, 'public');

                gambar_produk::create([
                    'id_produk' => $produk->id,
                    'gambar' => $path,
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // 🟡 UPDATE PRODUK
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required',
            'id_toko' => 'required',
            'nama_produk' => 'required|max:50',
            'deskripsi' => 'required',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk->update([
            'id_kategori' => $request->id_kategori,
            'id_toko' => $request->id_toko,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $namaProduk = str_replace(' ', '_', strtolower($produk->nama_produk));
                $namaFile = $namaProduk . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();

                $path = $file->storeAs('produk', $namaFile, 'public');

                gambar_produk::create([
                    'id_produk' => $produk->id,
                    'gambar' => $path,
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    // 🔴 HAPUS PRODUK + SEMUA GAMBAR
    public function destroy($id)
    {
        $produk = Produk::with('gambarProduks')->findOrFail($id);

        foreach ($produk->gambarProduks as $g) {
            Storage::disk('public')->delete($g->gambar);
            $g->delete();
        }

        $produk->delete();

        return back()->with('success', 'Produk dan gambarnya berhasil dihapus!');
    }

    // 🔴 HAPUS GAMBAR SATUAN
    public function deleteGambar($id)
    {
        $gambar = gambar_produk::findOrFail($id);
        Storage::disk('public')->delete($gambar->gambar);
        $gambar->delete();
        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}
