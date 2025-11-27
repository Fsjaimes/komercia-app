<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Login basado en SESIÓN (requerido para Inertia)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    // Intenta autenticar al usuario en la SESIÓN
    if (Auth::attempt($credentials, $request->filled('remember'))) {
        // Regenerar la sesión para prevenir fijación de sesión
        $request->session()->regenerate();

        return response()->json(['message' => 'Login exitoso']);
    }

    return response()->json(['error' => 'Credenciales inválidas'], 401);
});

// Logout de sesión
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->noContent();
});

// Obtener usuario autenticado (para verificar sesión)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth');