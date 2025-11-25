<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reviews extends Model
{
    //
    protected $guarded = [];
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
