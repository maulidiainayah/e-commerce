<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkout'; // default-nya 'checkouts', jadi kamu harus tentukan

    protected $fillable = [
        'resi',
        'tanggal',
        'user_id',
        'keranjang_ids',
        'status',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'keranjang_ids' => 'array', // otomatis decode JSON ke array
        'tanggal' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
