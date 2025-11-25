<?php

namespace App\Http\Controllers;

use App\Models\gambar_produk;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Toko;
use App\Models\User;
use App\Models\TokoController; // kalau ini model toko kamu
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // 🟢 STATISTIK UTAMA
        $totalProduk = Produk::count();
        $totalKategori = Kategori::count();
        $totalUser = User::count();
        $totalToko = Toko::count();

        // 🟡 DATA GRAFIK: Ambil kategori dan hitung jumlah produk per kategori
        $kategori = Kategori::withCount('produk')->get();
        $namaKategori = $kategori->pluck('nama_kategori');       // label untuk grafik
        $jumlahProdukPerKategori = $kategori->pluck('produk_count'); // data jumlah per kategori

        // 🟢 PRODUK TERBARU (5 produk terakhir)
        $produkTerbaru = Produk::orderBy('tanggal_upload', 'desc')->take(5)->get();

        // 🟠 PRODUK DENGAN STOK TERTINGGI & TERENDAH
        $produkStokTinggi = Produk::orderByDesc('stok')->first();
        $produkStokRendah = Produk::orderBy('stok')->first();

        // 🔴 PRODUK DENGAN STOK RENDAH (stok <= 5)
        $produkStokRendahList = Produk::where('stok', '<=', 5)->get();

        // 🔵 KIRIM SEMUA DATA KE VIEW
        return view('admin.dashboard', compact(
            'totalProduk',
            'totalKategori',
            'totalUser',
            'totalToko',
            'namaKategori',
            'jumlahProdukPerKategori',
            'produkTerbaru',
            'produkStokTinggi',
            'produkStokRendah',
            'produkStokRendahList'
        ));
    }
    public function Auth(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Ambil input username & password
        $credentials = $request->only('username', 'password');

        // Cek login menggunakan Auth
        if (Auth::attempt($credentials)) {

            // Cek role user setelah login
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard'); // redirect ke dashboard admin
            } elseif (Auth::user()->role == 'member') {
                return redirect()->route('member.toko'); // redirect ke dashboard operator
            } else {
                return redirect()->back(); // role lain, balik ke login
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function login()
    {
        return view('login');
    }
    public function registrasi()
    {
        return view('registrasi');
    }
    public function regis(Request $request)
    {
         // Validasi input
        $request->validate([
            'nama' => 'required|max:30',
            'kontak' => 'nullable|max:13',
            'username' => 'required|max:20|unique:users,username',
            'password' => 'required|min:3',
        ]);

        // Simpan data ke database
        $user = User::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'username' => $request->username,
            'password' => bcrypt($request->password), // ← pastikan di-hash
            'role' => 'member',
        ]);

        // Cek apakah berhasil
        if ($user) {
            return redirect()->back()->with('success', 'User berhasil ditambahkan!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan user.');
        }
    }
public function gambarProduk()
{
    $gambar = gambar_produk::all();
    return view('admin.gambar-produk', compact('gambar'));
}

public function update(Request $request, $id)
{
    $gambar = gambar_produk::findOrFail($id);

    $request->validate([
        'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    # Hapus gambar lama
    $oldPath = public_path('storage/' . $gambar->gambar);
    if (file_exists($oldPath)) {
        unlink($oldPath);
    }

    # Upload gambar baru
    $file = $request->file('gambar');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $file->move(public_path('storage/'), $fileName);

    # Update database
    $gambar->update([
        'gambar' => $fileName,
    ]);

    return back()->with('success', 'Gambar berhasil diperbarui!');
}

public function delete($id)
{
    $gambar = gambar_produk::findOrFail($id);

    # Hapus file
    $path = public_path('storage/' . $gambar->gambar);
    if (file_exists($path)) {
        unlink($path);
    }

    # Hapus database
    $gambar->delete();

    return back()->with('success', 'Gambar berhasil dihapus!');
}
public function search(Request $request)
{
   $q = $request->q;

    // Cari Produk + relasi kategori + relasi toko
    $produk = Produk::with(['kategori', 'toko'])
        ->where('nama_produk', 'like', "%$q%")
        ->orWhereHas('kategori', function ($kat) use ($q) {
            $kat->where('nama_kategori', 'like', "%$q%");
        })
        ->orWhereHas('toko', function ($t) use ($q) {
            $t->where('nama_toko', 'like', "%$q%");
        })
        ->get();

    return view('admin.search', compact('produk', 'q'));
}
}
