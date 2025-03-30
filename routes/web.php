<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas de autenticación con Google
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::resource('urls', UrlController::class);
    // Otras rutas protegidas...
});

// Ruta para redirección (debe ir al final para no interferir con otras rutas)
Route::get('/{code}', [RedirectController::class, 'redirect'])->name('url.redirect');
