<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{

    protected $table = 'keranjang'; 
    protected $fillable = ['iduser', 'idproduk', 'qty'];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'idproduk');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
