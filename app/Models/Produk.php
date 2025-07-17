<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{

    protected $fillable = [
        'nama', 'deskripsi', 'stok', 'harga', 'gambar', 'idkategori'
    ];

    protected $casts = [
        'gambar' => 'array', // ⬅️ Ini penting agar json_decode otomatis
    ];

    public function kategori()
    {
    return $this->belongsTo(Kategori::class, 'idkategori');
    }

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }
}
