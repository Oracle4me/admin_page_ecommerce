<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Controllers\AdminController;
use App\Modules\Auth\Controllers\AuthController;

Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'viewAdminDashboard'])
            ->name('admin.dashboard');

        Route::get('/dashboard/stats', [AdminController::class, 'dashboardStats'])
            ->name('dashboardStats');

        Route::get('/logout', [AuthController::class, 'logout'])
            ->name('adminLogout');
    });
