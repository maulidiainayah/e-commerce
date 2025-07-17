<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
     protected $table = 'stok';

    protected $fillable = [
        'produk_id', 'jumlah', 'resi'
    ];

    public function product()
    {
        return $this->belongsTo(Produk::class);
    }
}
