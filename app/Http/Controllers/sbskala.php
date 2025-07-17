<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori; 
use App\Models\Keranjang;   
use App\Models\Stok;
use App\Models\Checkout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        return view('admin.databarang', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    
        {
            $kategori = Kategori::all();
            return view('admin.inputbarang', compact('kategori'));
        }
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'foto_produk' => 'required|image|max:2048',
            'harga' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'idkategori' => 'required|exists:kategori,id',
            'deskripsi' => 'nullable|string', 
        ]);
        $path = $request->file('foto_produk')->store('foto_produk-barang', 'public');

        Barang::create([
            'nama_produk' => $validated['nama_produk'],
            'foto_produk' => $path,
            'harga' => $validated['harga'],
            'qty' => $validated['qty'],
            'idkategori' => $validated['idkategori'],
            'deskripsi' => $validated['deskripsi'],
        ]);
        return redirect()->route('databarang.index')->with('success', 'Produk berhasil ditambahkan.');



    
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
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::all();
    return view('admin.edit', compact('barang', 'kategori')); 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $barang = Barang::findOrFail($id);

    $validated = $request->validate([
        'nama_produk' => 'required|string',
        'foto_produk' => 'nullable|image|max:2048',
        'harga' => 'required|numeric',
        'qty' => 'required|integer',
        'idkategori' => 'required|integer',
        'deskripsi' => 'nullable|string',
    ]);

    if ($request->hasFile('foto_produk')) {
        // Hapus gambar lama
        if ($barang->foto_produk && Storage::disk('public')->exists($barang->foto_produk)) {
            Storage::disk('public')->delete($barang->foto_produk);
        }

        // Simpan gambar baru
        $validated['foto_produk'] = $request->file('foto_produk')->store('foto_produk-barang', 'public');
        $validated['idkategori'] = $request->idkategori;

    $barang->update($validated);

    return redirect()->route('databarang.index')->with('success', 'Produk berhasil diperbarui.');
    }
}
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::find($id);
    
        $barang->delete();
        return redirect()->route('databarang.index')->with('success', 'Produk berhasil dihapus');
    }

    public function shop()
{

     $barang = Barang::all();
    $kategori = Kategori::withCount('barang')->get(); // Mengambil semua kategori beserta jumlah barangnya
    return view('user.shop', compact('kategori','barang')); // ← arahkan ke 'user.shop'
}
public function detail($id)
{
     $barang = Barang::with('kategori')->find($id); // Ambil berdasarkan ID

    if (!$barang) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

    return view('user.detail', compact('barang'));
}


public function barangByKategori($id)
{
    $kategori = Kategori::all(); // ambil semua kategori
    $barang = Barang::where('idkategori', $id)->get(); // ambil barang berdasarkan kategori

    return view('user.shop', compact('barang', 'kategori'));
}
public function tambahKeKeranjang(Request $request, $id)
{
    $jumlah = (int) $request->input('jumlah', 1);
    $userId = Auth::id();

    $item = Keranjang::where('barang_id', $id)->where('user_id', $userId)->first();

    if ($item) {
        $item->jumlah_produk += $jumlah;
        $item->save();
    } else {
        Keranjang::create([
            'barang_id' => $id,
            'jumlah_produk' => $jumlah,
            'user_id' => $userId,
        ]);
    }

    return redirect()->route('user.keranjang')->with('success', 'Produk ditambahkan ke keranjang');
}
public function showKeranjang()
{
    $keranjang = Keranjang::with('barang')->where('user_id', Auth::id())->get();
    return view('user.keranjang', compact('keranjang'));
}

public function hapusDariKeranjang($id)
{
    $item = Keranjang::findOrFail($id);
    $item->delete();

    return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
}
public function checkout()
{
    $userId = Auth::id();
    $items = Keranjang::where('user_id', $userId)->get();

    foreach ($items as $item) {
        Checkout::create([
            'tanggal' => now(),
            'user_id' => $userId,
            'keranjang_id' => $item->id,
            'status' => 'menunggu_verifikasi',
        ]);
    }

    return redirect()->route('user.checkout.status')->with('success', 'Berhasil checkout, menunggu verifikasi admin.');
}
public function verifikasiCheckout($id)
{
    $checkout = Checkout::findOrFail($id);

    // Update status dan beri nomor resi
    $checkout->update([
        'status' => 'verifikasi_berhasil',
        'no_resi' => 'RESI-' . strtoupper(uniqid())
    ]);

    // Hapus data keranjang
    Keranjang::where('id', $checkout->keranjang_id)->delete();

    return back()->with('success', 'Verifikasi berhasil. Data keranjang sudah dihapus.');
}
}