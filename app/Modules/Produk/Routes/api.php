<?php

use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Produk\Controllers\Api\InvoiceController;
use App\Modules\Produk\Controllers\Api\applyVoucherController;
use App\Modules\Produk\Controllers\Api\BrandController;
use App\Modules\Produk\Controllers\Api\CheckoutController;
use App\Modules\Produk\Controllers\Api\KategoriController;
use Illuminate\Support\Facades\Route;
use App\Modules\Produk\Controllers\Api\ProdukController;
use App\Modules\Produk\Controllers\Api\VoucherController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');
Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth');
Route::middleware('jwt.auth')->get('/invoice-last', [InvoiceController::class, 'lastInvoice']);


Route::get('/brand/view', [BrandController::class, 'view'])->name('brand.view');
Route::get('/kategori/view', [KategoriController::class, 'view'])->name('kategori.view');
Route::get('/produk/{slug}', [ProdukController::class, 'show'])->name('produk.show');
Route::post('/cart/apply-voucher', [applyVoucherController::class, 'applyVoucher']);
Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout.process')->middleware('jwt.auth');
Route::get('/invoice/{order_id}', [InvoiceController::class, 'show'])->name('invoice.show');
// Voucher AKtif
Route::get('/vouchers/active', [VoucherController::class, 'active']);


Route::prefix('produk')->group(function () {
    Route::get('/', [ProdukController::class, 'view']);
    Route::get('/{id}', [ProdukController::class, 'show']);
});

Route::prefix('produk')
->middleware(['jwt.auth'])
    ->group(function () {
        Route::post('/', [ProdukController::class, 'store']);
        Route::put('/{id}', [ProdukController::class, 'update']);
        Route::delete('/{id}', [ProdukController::class, 'destroy']);
    });

