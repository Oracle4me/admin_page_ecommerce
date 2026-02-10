<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Route global / non-module
|--------------------------------------------------------------------------
*/

// Redirect root
Route::get('/', fn () => redirect('/admin/login'));

// Auth global (kalau ada)
Route::get('/login', fn () => redirect('/admin/login'));
