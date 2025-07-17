<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Models\Checkout;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route::group('middleware' => ['auth', 'role:dosen'])
Route::get('user/dashboard', [HomeController::class, 'userDashboard'])
->middleware(['auth', 'role:user']);
Route::get('admin/dashboard', [HomeController::class, 'adminDashboard'])
->middleware(['auth', 'role:admin']);


// Route::prefix('user')->group(function () {
//     Route::get('barang', [UserBarangController::class, 'index']);
// });

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('produk', ProdukController::class);
    Route::get('checkout', [HomeController::class, 'checkout'])->name('checkout');
    Route::put('checkout/verifikasi/{id}', [KeranjangController::class, 'verifikasi'])->name('checkout.verifikasi');
    Route::get('mutasi', [HomeController::class, 'mutasi'])->name('mutasi');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('user/dashboard', [HomeController::class, 'userDashboard'])->name('dashboard');
    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
    Route::get('/shop/kategori/{id}', [HomeController::class, 'produkByKategori']);
    Route::get('/shop/detail/{id}', [ProdukController::class, 'show'])->name('detail');
    Route::post('/add-to-cart', [KeranjangController::class, 'store'])->name('cart.store');
    Route::get('/cart', [KeranjangController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{id}', [KeranjangController::class, 'destroy'])->name('cart.destroy');
    // Kirim checkout (POST) — dari form user
//     Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('checkout.store');
//     // Tampilkan daftar checkout yang belum diverifikasi (opsional untuk user lihat status)
//     // Route::get('/checkout/waiting', [KeranjangController::class, 'waiting'])->name('checkout.waiting');
//     Route::get('/checkout/waiting', function () {
//     return view('user.checkout'); // pastikan view-nya ada
// })->name('checkout.waiting');
Route::get('/checkout', [KeranjangController::class, 'showCheckoutPage'])->name('checkout.page');
Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('checkout.store');

Route::get('/checkout/success/{id}', function ($id) {
    $checkout = App\Models\Checkout::findOrFail($id);
    $keranjangIds = json_decode($checkout->keranjang_ids, true);

    $keranjangs = App\Models\Keranjang::with('product')
        ->whereIn('id', $keranjangIds)
        ->get();

    return view('user.berhasilco', compact('checkout', 'keranjangs'));
})->name('checkout.success');

});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');




