<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasi'; // nama tabel

    protected $fillable = [
        'idproduk',
        'user_id',
        'm_k',
        'no_resi',
        'qty',
        'harga_satuan',
        'subtotal',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'idproduk');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
