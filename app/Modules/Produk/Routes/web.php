<?php

use App\Modules\Produk\Controllers\Api\BrandController;
use App\Modules\Produk\Controllers\Api\VoucherController;
use App\Modules\Produk\Controllers\Api\KategoriController;
use App\Modules\Produk\Controllers\Api\OrderController;
use App\Modules\Produk\Controllers\Api\ProdukController;
use App\Modules\Produk\Controllers\Api\StokController;
use App\Modules\Produk\Controllers\Api\UkuranController;
use App\Modules\Produk\Controllers\Api\WarnaController;
use App\Modules\Produk\Controllers\Web\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Modules\Produk\Controllers\Web\ProdukViewController;

Route::prefix('admin')
    ->middleware(['web', 'auth', 'role:admin'])
    ->group(function () {
        
        Route::get('/dashboard', [ProdukViewController::class, 'dashboard'])->name('dashboard.index');
        Route::get('/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');
        Route::get('dashboard/sales-chart', [DashboardController::class, 'salesChart']);
        Route::get('dashboard/stock-chart', [DashboardController::class, 'stockChart']);
        Route::get('dashboard/transaction-summary', [DashboardController::class, 'transactionSummary']);
        Route::get('dashboard/top-customers', [DashboardController::class, 'topCustomers'])->name('dashboard.top-customers');

        Route::get('/kategori', [ProdukViewController::class, 'kategori'])->name('kategori.index');
        Route::get('/kategori/view', [KategoriController::class, 'view'])->name('kategori.view');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy') ;


        Route::get('/brand', [ProdukViewController::class, 'brand'])->name('brand.index');
        Route::get('/brand/view', [BrandController::class, 'view'])->name('brand.view');
        Route::post('/brand', [BrandController::class, 'store'])->name('brand.store');
        Route::put('/brand/{id}', [BrandController::class, 'update'])->name('brand.update');
        Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('brand.destroy') ;

        Route::get('/produk', [ProdukViewController::class, 'produk'])->name('produk.index');
        Route::get('/produk/tambah', [ProdukViewController::class, 'tambahProduk'])->name('tambah_produk.index');
        Route::get('/produk/view', [ProdukController::class, 'view'])->name('produk.view');
        Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy') ;

        Route::get('/voucher', [ProdukViewController::class, 'voucher'])->name('voucher.index');
        Route::get('/voucher/view', [VoucherController::class, 'view'])->name('voucher.view');
        Route::post('/voucher', [VoucherController::class, 'store'])->name('voucher.store');
        Route::put('/voucher/{id}', [VoucherController::class, 'update'])->name('voucher.update');
        Route::delete('/voucher/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy') ;


        Route::get('/ukuran', [ProdukViewController::class, 'ukuran'])->name('ukuran.index');
        Route::get('/ukuran/view', [UkuranController::class, 'view'])->name('ukuran.view');
        Route::post('/ukuran', [UkuranController::class, 'store'])->name('ukuran.store');
        Route::put('/ukuran/{id}', [UkuranController::class, 'update'])->name('ukuran.update');
        Route::delete('/ukuran/{id}', [UkuranController::class, 'destroy'])->name('ukuran.destroy') ;
        
        Route::get('/warna', [ProdukViewController::class, 'warna'])->name('warna.index');
        Route::get('/warna/view', [WarnaController::class, 'view'])->name('warna.view');
        Route::post('/warna', [WarnaController::class, 'store'])->name('warna.store');
        Route::put('/warna/{id}', [WarnaController::class, 'update'])->name('warna.update');
        Route::delete('/warna/{id}', [WarnaController::class, 'destroy'])->name('warna.destroy') ;
        
        Route::get('/stok-inventory', [ProdukViewController::class, 'stokInventory'])->name('stok-inventory.index');  
        Route::get('/stok-inventory/view', [StokController::class, 'view'])->name('stok-inventory.view');
        Route::post('/stok-inventory', [StokController::class, 'store'])->name('stok-inventory.store');
        Route::put('/stok-inventory/{id}', [StokController::class, 'update'])->name('stok-inventory.update');
        Route::delete('/stok-inventory/{id}', [StokController::class, 'destroy'])->name('stok-inventory.destroy') ;


        Route::get('/order', [ProdukViewController::class, 'order'])
            ->name('order.index');
        Route::get('/order/view', [OrderController::class, 'view'])->name('order.view');
        Route::post('/order/{id}/status', [OrderController::class, 'update'])->name('order.update.status');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');

    });
