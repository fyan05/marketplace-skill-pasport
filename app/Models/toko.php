<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class toko extends Model
{
    //
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function produk()
    {
        return $this->hasMany(produk::class,'id_toko');
    }

}
