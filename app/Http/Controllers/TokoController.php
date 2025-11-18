<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\toko as ModelsToko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    public function index()
    {
        $toko = Toko::with('user')->get();
        $user = User::all();
        return view('admin.toko', compact('toko', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required',
            'deskripsi_toko' => 'required',
            'kontak_toko' => 'required',
            'alamat_toko' => 'required',
            'user_id' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'nama_toko',
            'deskripsi_toko',
            'kontak_toko',
            'alamat_toko',
            'user_id'
        ]);

        if ($request->hasFile('gambar')) {
            $fileName = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->storeAs('public/fototoko', $fileName);
            $data['gambar'] = $fileName;
        }

        Toko::create($data);

        return back()->with('success', 'Toko berhasil ditambahkan');
    }

    public function update(Request $request, Toko $toko )
    {

            $request->validate([
            'id'=> 'required',
            'nama_toko' => 'required',
            'deskripsi_toko' => 'required',
            'kontak_toko' => 'required',
            'alamat_toko' => 'required',
            'user_id' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $foto = $toko->gambar;
        if ($request->hasFile('gambar')) {
            $foto = $request->file('gambar')->store('berita', 'public');
        }

        $toko = Toko::findOrFail($request->id);

        $toko->update([
            'id'=> $request->id,
            'nama_toko' => $request->nama_toko,
            'deskripsi_toko' => $request->deskripsi_toko,
            'kontak_toko' => $request->kontak_toko,
            'alamat_toko' => $request->alamat_toko,
            'user_id' => $request->user_id,
            'gambar'=>$foto,
        ]);

        return redirect()->route('admin.toko')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        // $id = Crypt::decrypt($id); // Dekripsi ID
        $toko = Toko::find($id);
        $toko->delete();
        return back()->with('success', 'Toko berhasil dihapus');
    }
}
