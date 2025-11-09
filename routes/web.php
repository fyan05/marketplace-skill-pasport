<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TokoControllerController;
use App\Http\Controllers\UserController;
use App\Models\TokoController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

#admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

#user
Route::get('/admin/user',[UserController::class,'index'])->name('admin.user');
Route::post('/admin/user/store',[UserController::class, 'store'])->name('admin.user-store');
Route::put('/admin/user/update/{id}',[UserController::class, 'update'])->name('admin.user-update');
Route::delete('/admin/user/delete/{id}',[UserController::class, 'destroy'])->name('admin.user-delete');

#produk
Route::get('/admin/user/produk',[ProdukController::class,'index'])->name('admin.produk');
Route::post('/admin/produk/store', [ProdukController::class, 'store'])->name('admin.produk-store');
Route::put('/admin/produk/update/{id}', [ProdukController::class, 'update'])->name('admin.produk-update');
Route::delete('/admin/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('admin.produk-delete');
Route::delete('/admin/produk/gambar/{id}', [ProdukController::class, 'deleteGambar'])->name('admin.produk.delete-gambar');

#kategori
Route::get('/admin/kategori',[KategoriController::class,'index'])->name('admin.kategori');
Route::post('/admin/kategori/store',[KategoriController::class,'store'])->name('admin.kategori-store');
Route::put('/admin/kategori/update/{id}',[KategoriController::class,'update'])->name('admin.kategori-update');
Route::delete('/admin/kategori/delete/{id}',[KategoriController::class,'destroy'])->name('admin.kategori-delete');

#toko
Route::get('/admin/toko',[TokoControllerController::class,'index'])->name('admin.toko');
Route::post('/admin/toko/store',[TokoControllerController::class,'store'])->name('admin.toko-store');
Route::put('/admin/toko/update/{id}',[TokoControllerController::class,'store'])->name('admin.toko-update');
Route::delete('/admin/toko/{id}',[TokoControllerController::class,'store'])->name('admin.toko-delete');

#user


