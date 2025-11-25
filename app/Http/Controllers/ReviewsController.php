<?php

namespace App\Http\Controllers;

use App\Models\reviews;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    //
   public function store(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nama' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'ulasan' => 'required',
        'foto' => 'nullable|image|max:2048'
    ]);

    // Siapkan variable foto default (null jika tidak upload)
    $fileName = null;

    // Cek apakah user upload foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/fotoreview', $fileName);
    }

    // Simpan ke database
    reviews::create([
        'produk_id' => $id,
        'nama' => $validated['nama'],
        'rating' => $validated['rating'],
        'ulasan' => $validated['ulasan'],
        'foto' => $fileName,
    ]);

    return back()->with('success', 'Ulasan berhasil dikirim!');
}


}
