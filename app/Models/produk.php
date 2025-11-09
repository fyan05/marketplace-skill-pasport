<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    //
    protected $guarded = [];
    public function toko()
    {
        return $this->belongsTo(TokoController::class,'id_toko');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class,'id_kategori');
    }
    public function gambarProduks()
    {
        return $this->hasMany(gambar_produk::class,'id_produk');
    }
}
