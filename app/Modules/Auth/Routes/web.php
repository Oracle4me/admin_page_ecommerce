<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Controllers\AuthController;



Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'viewLoginAdmin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'loginAdmin'])->name('admin.login.post');
    Route::post('/logout', [AuthController::class, 'logoutAdmin'])->name('admin.logout');
});
