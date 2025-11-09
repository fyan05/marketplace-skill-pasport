<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 🟢 TAMPILKAN SEMUA USER
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.user', compact('users'));
    }

    // 🟢 SIMPAN USER BARU
public function store(Request $request)
{
    // Validasi input
        $request->validate([
            'nama' => 'required|max:30',
            'kontak' => 'nullable|max:13',
            'username' => 'required|max:20|unique:users,username',
            'password' => 'required|min:3',
            'role' => 'required|in:admin,member',
        ]);

        // Simpan data ke database
        $user = User::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'password' => bcrypt($request->password), // ← pastikan di-hash
            'role' => $request->role,
        ]);

        // Cek apakah berhasil
        if ($user) {
            return redirect()->back()->with('success', 'User berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan user.');
        }
    }



    // 🟡 UPDATE DATA USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:30',
            'kontak' => 'nullable|max:13',
            'username' => 'required|max:20|unique:users,username,' . $id,
            'role' => 'required|in:admin,member',
        ]);

        $data = $request->only(['nama', 'kontak', 'username', 'role']);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diperbarui!');
    }

    // 🔴 HAPUS USER
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
