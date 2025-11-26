<?php

namespace App\Http\Controllers;

use App\Models\gambar_produk;
use App\Models\produk;
use App\Models\reviews;
use App\Models\Toko;
use App\Models\toko as ModelsToko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
            'status' =>'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

       if ($request->hasFile('gambar')) {
            $fileName = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->storeAs('public/fototoko', $fileName);
            $data['gambar'] = $fileName;
        }

        $toko = Toko::findOrFail($request->id);

        $toko->update([
            'id'=> $request->id,
            'nama_toko' => $request->nama_toko,
            'deskripsi_toko' => $request->deskripsi_toko,
            'kontak_toko' => $request->kontak_toko,
            'alamat_toko' => $request->alamat_toko,
            'status' =>$request->status,
            'user_id' => $request->user_id,
            'gambar'=>$fileName ?? $toko->gambar,
        ]);

        return redirect()->route('admin.toko')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        // $id = Crypt::decrypt($id); // Dekripsi ID
        reviews::whereHas('produk',function($uu) use ($id){
            $uu->where('id_toko',$id);
        })->delete();
        gambar_produk::whereHas('produk',function($gambar) use($id){
            $gambar->where('id_toko',$id);
        })->delete();
        $toko = Toko::find($id);
        $produk = produk::where('id_toko',$id)->delete();
        $toko->delete();
        return back()->with('success', 'Toko berhasil dihapus');
    }
    public function indexMember()
    {
        $userId = Auth::id();
        $user = Auth::user();

         if (!$userId) {
        return redirect()->route('login')->with('error', 'Silakan login dulu');
    }
        $toko = Toko::where('user_id', $userId)->first();
        return view('member.toko', compact('toko', 'user'));
    }


    public function MemberTok(Request $request)
    {
        $request->validate([
            'nama_toko' => 'required',
            'deskripsi_toko' => 'required',
            'kontak_toko' => 'required',
            'alamat_toko' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

       if ($request->hasFile('gambar')) {
            $fileName = time() . '_' . $request->gambar->getClientOriginalName();
            $request->gambar->storeAs('public/fototoko', $fileName);
            $data['gambar'] = $fileName;
        }

        Toko::create([
            'user_id' => Auth::id(),
            'alamat_toko' => $request->alamat_toko,
            'kontak_toko' => $request->kontak_toko,
            'nama_toko' => $request->nama_toko,
            'status' => 'pending',
            'deskripsi_toko' => $request->deskripsi_toko,
            'gambar' => $fileName ?? null,
        ]);


        return back()->with('success', 'Toko berhasil ditambahkan');
    }

    public function MemberUpd(Request $request, $id )
    {

        $request->validate([
        'nama_toko' => 'required',
        'deskripsi_toko' => 'required',
        'kontak_toko' => 'required',
        'alamat_toko' => 'required',
        'gambar' => 'nullable|image|max:2048',
    ]);

    // Ambil data toko
    $toko = Toko::findOrFail($id);

    // Simpan nama gambar lama
    $fileName = $toko->gambar;

    // Jika upload gambar baru
    if ($request->hasFile('gambar')) {
        $fileName = time() . '_' . $request->gambar->getClientOriginalName();
        $request->gambar->storeAs('public/fototoko', $fileName);
    }
    // Kalau status bukan aktif, ubah ke pending
    $statusBaru = ($toko->status == 'active') ? 'active' : 'pending';
//     dd([
//     'status_sekarang' => $toko->status,
//     'status_baru' => $statusBaru,
// ]);
    // Update data toko
    $toko->update([
        'nama_toko' => $request->nama_toko,
        'deskripsi_toko' => $request->deskripsi_toko,
        'kontak_toko' => $request->kontak_toko,
        'alamat_toko' => $request->alamat_toko,
        'gambar' => $fileName,
        'status' => $statusBaru,
    ]);

    return redirect()->route('member.toko')->with('success', 'Toko berhasil diperbarui');

    }
}
