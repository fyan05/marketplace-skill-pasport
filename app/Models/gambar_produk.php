<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gambar_produk extends Model
{
    //
    protected $guarded = [];
    public function produk()
    {
        return $this->belongsTo(produk::class,'id_produk');
    }
}
