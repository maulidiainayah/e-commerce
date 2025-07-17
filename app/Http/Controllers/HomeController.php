<?php

namespace App\Http\Controllers;
use App\Http\Controllers\ProdukController;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Checkout;
use App\Models\Mutasi;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }
    
    public function userDashboard()
    {
        $produk = Produk::all();
        return view('user.dashboard', compact('produk'));
    }

    public function shop()
    {
        $produk = Produk::all();
        $kategori = Kategori::all();
        return view('user.shop', compact('produk', 'kategori'));
    }

    public function produkByKategori($id)
    {
    $produk = Produk::where('idkategori', $id)->get();
    $kategori = Kategori::all();
    return view('user.shop', compact('produk', 'kategori'));
    }

//     public function verify($id)
// {
//     $checkout = DB::table('checkout')->where('id', $id)->first();
//     $cartIds = json_decode($checkout->keranjang_ids);

//     // Ambil data keranjang terkait
//     $carts = DB::table('keranjang')->whereIn('id', $cartIds)->get();

//     foreach ($carts as $cart) {
//         // 1. Kurangi stok
//         DB::table('barang')->where('id', $cart->idbarang)->decrement('jumlah', $cart->qty);

//         // 2. Tambahkan ke mutasi
//         DB::table('mutasi')->insert([
//             'resi' => $checkout->resi,
//             'id_stok' => null, // bisa kamu isi kalau stok dikelola per batch
//             'jumlah' => $cart->qty,
//             'status' => 'k',
//             'sub_total' => 0,
//             'sisa_barang' => 0,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
//     }

//     // 3. Hapus keranjang
//     DB::table('keranjang')->whereIn('id', $cartIds)->delete();

//     // 4. Update status checkout
//     DB::table('checkout')->where('id', $id)->update([
//         'status' => 'verified',
//         'updated_at' => now()
//     ]);

//     return back()->with('success', 'Checkout berhasil diverifikasi.');
// }

// AdminCheckoutController.php
public function checkout()
{
    $checkouts = Checkout::where('status', 'pending')->with('user')->latest()->get();
    return view('admin.checkout', compact('checkouts'));
}

public function mutasi()
{
    $mutasi = Mutasi::with('produk')->latest()->get();
    return view('admin.mutasi', compact('mutasi'));
}


}

