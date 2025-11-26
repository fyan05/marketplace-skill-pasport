<?php

namespace App\Http\Controllers;

use App\Models\gambar_produk;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\GambarProduk;
use App\Models\Toko;
use App\Models\TokoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\fileExists;

class ProdukController extends Controller
{
    // 🟢 TAMPIL SEMUA PRODUK
    public function index()
    {
        $produks = Produk::with(['kategori', 'gambarProduks'])->orderBy('id', 'DESC')->get();
        $kategori = Kategori::all();
        $toko =Toko::all();
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

        $produk = produk::find($id);

        if ($produk->gambar && $produk->gambar->count()>0){
            foreach($produk->gambar as $gambar){
                $path = public_path('storage/product/' .$gambar->gambar);

                if (fileExists($path)){
                    unlink($path);
                }

                $gambar->delete();
            }
        }

        if ($produk->reviews && $produk->reviews->count()>0){
            foreach($produk->reviews as $v){
                $v->delete();
            }
        }

        $produk->delete();

        return back()->with('success','produk berhasil di hapus');
    }

    #member
    // 🟢 LIST PRODUK PENJUAL
    public function MemberIndex()
    {
        $userId = Auth::id();
        $toko = Toko::where('user_id', $userId)->first();

        if (!$toko) {
            return redirect()->route('member.toko')
                ->with('error', 'Silakan buat toko terlebih dahulu.');
        }

        $produks = Produk::with('gambarProduks', 'kategori')
                    ->where('id_toko', $toko->id)
                    ->get();

        $kategori = Kategori::all();

        return view('member.produk', compact('produks', 'toko', 'kategori'));
    }

    // 🟢 SIMPAN PRODUK BARU
    public function MemberProd(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_produk' => 'required|max:50',
            'deskripsi' => 'required',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $toko = Toko::where('user_id', Auth::id())->first();

        $produk = Produk::create([
            'id_kategori' => $request->id_kategori,
            'id_toko' => $toko->id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'tanggal_upload' => now(),
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $nama = str_replace(' ', '_', strtolower($produk->nama_produk));
                $fileName = $nama.'_'.time().'_'.$index.'.'.$file->getClientOriginalExtension();

                $path = $file->storeAs('produk', $fileName, 'public');

                gambar_produk::create([
                    'id_produk' => $produk->id,
                    'gambar' => $path,
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    // 🟡 UPDATE PRODUK
    public function MemberUpd(Request $request, $id)
    {
        $produk = Produk::where('id', $id)
                    ->where('id_toko', Auth::user()->toko->id)
                    ->firstOrFail(); // keamanan: hanya produk milik toko sendiri

        $request->validate([
            'id_kategori' => 'required',
            'nama_produk' => 'required|max:50',
            'deskripsi' => 'required',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'gambar.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $produk->update($request->only('id_kategori', 'nama_produk', 'deskripsi', 'harga', 'stok'));

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $index => $file) {
                $nama = str_replace(' ', '_', strtolower($produk->nama_produk));
                $fileName = $nama.'_'.time().'_'.$index.'.'.$file->getClientOriginalExtension();

                $path = $file->storeAs('produk', $fileName, 'public');

                gambar_produk::create([
                    'id_produk' => $produk->id,
                    'gambar' => $path,
                ]);
            }
        }

        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    // 🔴 HAPUS PRODUK
    public function MemberHapus($id)
    {

        $produk = produk::find($id);

        if ($produk->gambar && $produk->gambar->count()>0){
            foreach($produk->gambar as $gambar){
                $path = public_path('storage/product/' .$gambar->gambar);

                if (fileExists($path)){
                    unlink($path);
                }

                $gambar->delete();
            }
        }

        if ($produk->reviews && $produk->reviews->count()>0){
            foreach($produk->reviews as $v){
                $v->delete();
            }
        }

        $produk->delete();

        return back()->with('success','produk berhasil di hapus');
    }
    public function gambarIndex($id)
        {
            $produk = Produk::findOrFail($id);
            $gambar = gambar_produk::where('id_produk', $id)->get();

            return view('member.gambar-produk', compact('produk', 'gambar'));
        }
    public function hapusGambar($id)
{
    $gambar = gambar_produk::findOrFail($id);

    // hapus file fisik
    $path = public_path('storage/produk/' . $gambar->gambar);
    if (file_exists($path)) {
        unlink($path);
    }

    $gambar->delete();

    return back()->with('success', 'Gambar berhasil dihapus');
}

}

