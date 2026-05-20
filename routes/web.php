<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SpkController;
use App\Models\Produk;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

/*
|--------------------------------------------------------------------------
| Redirect awal
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/ganti-password', [AuthController::class, 'showGantiPassword']);
Route::post('/ganti-password', [AuthController::class, 'updatePassword']);

/*
|--------------------------------------------------------------------------
| SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalProduk' => Produk::count(),
            'barangMasuk' => BarangMasuk::count(),
            'barangKeluar' => BarangKeluar::count(),
            'totalStok' => Produk::sum('stok'),
        ]);
    })->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::resource('barang-keluar', BarangKeluarController::class);

});

//Laporan//
Route::get('/laporan', function () {
    return view('laporan.index');
});

Route::get('/laporan/masuk', [BarangMasukController::class, 'laporan']);
Route::get('/laporan/keluar', [BarangKeluarController::class, 'laporan']);


Route::get('/spk', [SpkController::class, 'index']);