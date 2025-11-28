<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// Rutas públicas
Route::get('/', function () {
    return Inertia::render('Login');
});

// Rutas de autenticación
require __DIR__.'/auth.php';

// Rutas protegidas con SESIÓN (no Sanctum tokens)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboards/sales', function () {
        return Inertia::render('dashboards/sales');
    });
    Route::get('productos', [ProductController::class, 'index']);
    Route::post('productos', [ProductController::class, 'store']);
    Route::put('productos/{id}', [ProductController::class, 'update']);
    Route::delete('productos/{id}', [ProductController::class, 'destroy']);
    Route::get('listarProductos', [ProductController::class, 'listarProductos']);

    require __DIR__.'/beauty.php';
});