<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori'; // pastikan ini sesuai dengan nama tabel di database

    protected $fillable = ['nama']; // kolom yang bisa diisi secara massal

    public function produks()
    {
        return $this->hasMany(Produk::class, 'idkategori');
    }
}
