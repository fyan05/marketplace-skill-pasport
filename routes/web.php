<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
#login dan registrasi
Route::get('/login',[AdminController::class,'login'])->name('login');
Route::post('/login/post',[AdminController::class, 'Auth'])->name('login.auth');
Route::get('/registrasi',[AdminController::class,'registrasi'])->name('registrasi');
Route::post('/registrasi/post',[AdminController::class,'regis'])->name('registrasi.post');
Route::post('/review/post{id}',[ReviewsController::class,'store'])->name('review.post');
#pengguna
Route::get('/',[PenggunaController::class,'index'])->name('pengguna.index');
Route::get('/produk/',[PenggunaController::class,'produk'])->name('pengguna.produk');
Route::get('/produk/detail/{id}',[PenggunaController::class,'detailproduk'])->name('produk.detail');
Route::get('/toko/{id}',[PenggunaController::class,'toko'])->name('detail.toko');
Route::get('/search', [PenggunaController::class, 'search'])->name('pengguna.search');
Route::get('/kategori/',[PenggunaController::class,'kategori'])->name('pengguna.kategori');



Route::middleware(['authmember'])->group(function (){
    Route::get('/logout',[AdminController::class,'logout'])->name('logout');
    Route::get('/member', [MemberController::class, 'index'])->name('member.dashboard');
    #produk
    Route::get('/member/produk', [ProdukController::class, 'MemberIndex'])->name('member.produk');
    Route::post('/member/produk/post',[ProdukController::class, 'MemberProd'])->name('member.produk-post');
    Route::put('/member/produk/update/{id}',[ProdukController::class, 'MemberUpd'])->name('member.produk-update');
    Route::delete('/member/produk/delete/{id}',[ProdukController::class, 'MemberHapus'])->name('member.produk-hapus');
    #toko
    Route::get('/member/toko',[TokoController::class,'indexMember'])->name('member.toko');
    Route::post('/member/toko/post',[TokoController::class, 'MemberTok'])->name('member.toko-post');
    Route::put('/member/toko/update/{id}',[TokoController::class, 'MemberUpd'])->name('member.toko-update');
    Route::get('/member/gambar',[MemberController::class, 'gambarProduk'])->name('member.gambar');
    Route::post('/member/gambar-produk/update/{id}',[MemberController::class, 'update'])->name('member.gambar.update');
    Route::delete('/member/gambar-produk/delete/{id}',[MemberController::class, 'delete'])->name('member.gambar.delete');
});

Route::middleware(['authadmin'])->group(function (){

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/search',[AdminController::class, 'search'])->name('admin.cari');

    #user
    Route::get('/admin/user',[UserController::class,'index'])->name('admin.user');
    Route::post('/admin/user/store',[UserController::class, 'store'])->name('admin.user-store');
    Route::put('/admin/user/update/{id}',[UserController::class, 'update'])->name('admin.user-update');
    Route::delete('/admin/user/delete/{id}',[UserController::class, 'destroy'])->name('admin.user-delete');

    #kategori
    Route::get('/admin/kategori',[KategoriController::class,'index'])->name('admin.kategori');
    Route::post('/admin/kategori/store',[KategoriController::class,'store'])->name('admin.kategori-store');
    Route::put('/admin/kategori/update/{id}',[KategoriController::class,'update'])->name('admin.kategori-update');
    Route::delete('/admin/kategori/delete/{id}',[KategoriController::class,'destroy'])->name('admin.kategori-delete');

    #produk
    Route::get('/admin/user/produk',[ProdukController::class,'index'])->name('admin.produk');
    Route::post('/admin/produk/store', [ProdukController::class, 'store'])->name('admin.produk-store');
    Route::put('/admin/produk/update/{id}', [ProdukController::class, 'update'])->name('admin.produk-update');
    Route::delete('/admin/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('admin.produk-delete');

    #toko
    Route::get('/admin/toko',[TokoController::class,'index'])->name('admin.toko');
    Route::get('/admin/toko/delete/{id}',[TokoController::class,'destroy'])->name('admin.toko-delete');
    Route::post('/admin/toko/store',[TokoController::class,'store'])->name('admin.toko-store');
    Route::put('/admin/toko/update/{id}',[TokoController::class,'update'])->name('admin.toko-update');
    Route::get('/logout',[AdminController::class,'logout'])->name('logout');

    #gambar
    Route::get('/member/produk/gambar', [AdminController::class, 'gambarProduk'])->name('admin.produk.gambar');
    Route::post('/member/gambar-produk/update/{id}',[AdminController::class, 'update'])->name('admin.gambar.update');
    Route::delete('/member/gambar-produk/delete/{id}',[AdminController::class, 'delete'])->name('admin.gambar.delete');
});
