<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // 🟢 TAMPILKAN SEMUA KATEGORI
    public function index()
    {
        $kategoris = Kategori::orderBy('id', 'DESC')->get();
        return view('admin.kategori', compact('kategoris'));
    }

    // 🟢 TAMBAH KATEGORI BARU
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:50|unique:kategoris,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    // 🟡 UPDATE KATEGORI
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|max:50|unique:kategoris,nama_kategori,' . $id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    // 🔴 HAPUS KATEGORI
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
