<?php

namespace App\Http\Controllers;

use App\Models\gambar_produk;
use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    //
    public function index()
    {
        return view('member.dashboard');
    }
    public function gambarProduk(){
            $user = Auth::user();
    if (!$user->toko) {
        return back()->with('error', 'Anda belum memiliki toko.');
    }

    $toko = $user->toko;
    $gambar = gambar_produk::with('produk')
        ->whereHas('produk', function ($query) use ($toko) {
            $query->where('id_toko', $toko->id);
        })
        ->get();

    $produk = produk::where('id_toko', $toko->id)->first();

    return view('member.gambar-produk', compact('gambar', 'produk'));

    }
        public function update(Request $request, $id)
    {
        $gambar = gambar_produk::findOrFail($id);

        $request->validate([
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if (file_exists(public_path('storage/'.$gambar->gambar))) {
            unlink(public_path('storage/'.$gambar->gambar));
        }

        $file = $request->file('gambar');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('storage/'), $fileName);

        $gambar->update([
            'gambar' => $fileName
        ]);

        return back()->with('success','Gambar berhasil diperbarui!');
    }

    public function delete($id)
    {
        $gambar = gambar_produk::findOrFail($id);

        if (file_exists(public_path('storage/imageproduk/'.$gambar->path_gambar))) {
            unlink(public_path('storage/imageproduk/'.$gambar->path_gambar));
        }

        $gambar->delete();

        return back()->with('success','Gambar berhasil dihapus!');
    }

}
