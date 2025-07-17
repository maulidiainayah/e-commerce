<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $produk = Produk::with('kategori')->get();
        return view('admin.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'idkategori' => 'required|exists:kategori,id',
            'gambar' => 'required|array', // Validasi array gambar
            'gambar.*' => 'image|max:2048', // Validasi setiap gambar
        ]);
    
        // Menyimpan gambar-gambar ke folder 'gambar-produk' di storage
        $gambarPaths = [];
        foreach ($request->file('gambar') as $file) {
            $path = $file->store('gambar-produk', 'public');
            $gambarPaths[] = $path;
        }
    
        // Simpan data produk ke database
        Produk::create([
            'nama' => $validated['nama'],
            'idkategori' => $validated['idkategori'],
            'deskripsi' => $validated['deskripsi'],
            'stok' => $validated['stok'],
            'harga' => $validated['harga'],
            'gambar' => json_encode($gambarPaths), // Menyimpan array path dalam format JSON
        ]);
    
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $produk = Produk::findOrFail($id);
         return view('user.detail', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
    return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produk = Produk::findOrFail($id);
    
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|array', // Validasi array gambar
            'gambar.*' => 'nullable|image|max:2048', // Validasi setiap gambar
            'idkategori' => 'required|exists:kategori,id',

        ]);
    
        // Cek apakah ada gambar baru yang di-upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage jika ada
            if ($produk->gambar) {
                $oldGambar = json_decode($produk->gambar);
                foreach ($oldGambar as $gambar) {
                    if (Storage::disk('public')->exists($gambar)) {
                        Storage::disk('public')->delete($gambar);
                    }
                }
            }
    
            // Simpan gambar-gambar baru
            $gambarPaths = [];
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('gambar-produk', 'public');
                $gambarPaths[] = $path;
            }
    
            $validated['gambar'] = json_encode($gambarPaths); // Update gambar dengan array baru
        }

        $validated['idkategori'] = $request->idkategori;
        // Update data produk
        $produk->update($validated);
    
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $produk = Produk::find($id);
    
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    
}

public function checkout(Request $request)
{
    $request->validate([
        'keranjang_ids' => 'required'
    ]);

    $cartIds = explode(',', $request->keranjang_ids);
    $userId = auth()->id();
    $resi = str_pad($userId, 3, '0', STR_PAD_LEFT) . now()->format('YmdHis');

    $checkout = Checkout::create([
        'resi' => $resi,
        'tanggal' => now(),
        'user_id' => $userId,
        'keranjang_ids' => json_encode($cartIds),
        'status' => 'pending',
    ]);

    return view('user.checkout', compact('checkout'));
}

public function uploadBuktiPembayaran(Request $request, $id)
{
    $request->validate([
        'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $checkout = Checkout::findOrFail($id);

    $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
    $checkout->update([
        'bukti_pembayaran' => $path,
        'status' => 'menunggu_verifikasi'
    ]);

    return redirect()->route('user.checkout.success')->with('success', 'Checkout berhasil, tunggu verifikasi admin.');
}



// Dalam ProdukController
// public function userIndex()
// {
//     $produk = Produk::all();
//     return view('user.produk', compact('produk'));
// }

}
