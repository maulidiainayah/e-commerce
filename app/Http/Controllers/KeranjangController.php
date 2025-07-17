<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Checkout;
use App\Models\Produk;
use App\Models\Mutasi;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Keranjang::with('product')->where('iduser', auth()->id())->get();
        return view('user.keranjang', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'idproduk' => 'required|exists:produks,id',
        'qty' => 'required|integer|min:1'
    ]);

    $cart = Keranjang::where('iduser', auth()->id())
        ->where('idproduk', $request->idproduk)
        ->first();

    if ($cart) {
        $cart->qty += $request->qty;
        $cart->save();
    } else {
        Keranjang::create([
            'iduser' => auth()->id(),
            'idproduk' => $request->idproduk,
            'qty' => $request->qty
        ]);
    }

   return redirect()->route('user.cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Keranjang::where('iduser', auth()->id())->findOrFail($id);
        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

public function showCheckoutPage(Request $request)
{
    $cartIds = explode(',', $request->query('keranjang_ids'));
    $userId = auth()->id();

    $keranjangs = Keranjang::with('product')
        ->whereIn('id', $cartIds)
        ->where('iduser', $userId)
        ->get();

    return view('user.checkout', compact('keranjangs', 'cartIds'));
}

public function checkout(Request $request)
{
    $request->validate([
        'keranjang_ids' => 'required',
        'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $cartIds = explode(',', $request->keranjang_ids);
    $userId = auth()->id();

    // Upload bukti
    $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

    $checkout = Checkout::create([
        'resi' => null,
        'tanggal' => now(),
        'user_id' => $userId,
        'keranjang_ids' => json_encode($cartIds),
        'bukti_pembayaran' => $buktiPath,
        'status' => 'pending',
    ]); 

    return redirect()->route('user.checkout.success', $checkout->id);
}

public function verifikasi($id)
{

    $checkout = Checkout::findOrFail($id);

    if ($checkout->status !== 'pending') {
        return back()->with('error', 'Sudah diverifikasi sebelumnya.');
    }

    // 1. Generate resi
    $resi = now()->format('YmdHis') . str_pad($checkout->user_id, 4, '0', STR_PAD_LEFT);

    // 2. Update status dan resi
    $checkout->status = 'verified';
    $checkout->resi = $resi;
    $checkout->save();

    // 3. Insert ke mutasi (loop isi keranjang)
    $cartIds = json_decode($checkout->keranjang_ids, true);
    foreach ($cartIds as $cartId) {
    $item = Keranjang::with('product')->find($cartId);

        Mutasi::create([
            'idproduk' => $item->idproduk,
            'user_id' => $checkout->user_id,
            'm_k' => 'keluar', // keluar
            'no_resi' => $resi,
            'qty' => $item->qty,
            'harga_satuan' => $item->product->harga,
            'subtotal' => $item->qty * $item->product->harga,
            'tanggal' => now(),
        ]);

        // 4. Kurangi stok produk
        $produk = $item->product;
        $produk->stok -= $item->qty;
        $produk->save();
    }

    return back()->with('success', 'Checkout diverifikasi. Resi: ' . $resi);
}

}