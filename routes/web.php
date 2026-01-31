<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\LaporanProduksiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokController;
use App\Models\Stok;
use App\Models\ProduksiDetail;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('login'); // Redirect root to login
    Route::get('/login', [UserController::class, 'index'])->name('login.form');
    Route::post('/login', [UserController::class, 'authenticate'])->name('login.perform');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Dashboard: Admin & Karyawan Only
    Route::middleware('role:admin,karyawan')->get('/welcome', function (\Illuminate\Http\Request $request) { 
        $stok = Stok::with('barang')->get();
        $filterDate = $request->input('date', date('Y-m-d'));
        $produksiSummary = ProduksiDetail::whereDate('tanggal_produksi', $filterDate)
                            ->selectRaw('SUM(target) as total_target, SUM(hasil) as total_hasil, SUM(reject) as total_reject')
                            ->first();

        return view('welcome', compact('stok', 'produksiSummary', 'filterDate')); 
    })->name('dashboard');

    // Superadmin Only Routes
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('admin', AdminController::class);
    });

    // Admin Only (Write access for Master/Transactions)
    Route::middleware('role:admin')->group(function () {
        Route::resource('produk', ProdukController::class);
        Route::resource('stok', StokController::class);
        
        // CUD for Laporan Produksi & Transaksi
        Route::resource('laporan_produksi', LaporanProduksiController::class)->except(['index', 'show']);
        Route::resource('transaksi', TransaksiController::class)->except(['index', 'show']);
    });

    // Admin & Karyawan (Read access for Laporan & Transaksi)
    Route::middleware('role:admin,karyawan')->group(function () {
        Route::resource('laporan_produksi', LaporanProduksiController::class)->only(['index', 'show']);
        Route::resource('transaksi', TransaksiController::class)->only(['index', 'show']);
    });

});