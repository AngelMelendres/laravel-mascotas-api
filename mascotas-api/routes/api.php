<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PersonaController;
use App\Http\Controllers\Api\MascotaController;
use App\Http\Controllers\AuthController;

// 🔓 Rutas públicas (no requieren token)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔐 Rutas protegidas (requieren token JWT)
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);

    // CRUD de personas
    Route::apiResource('personas', PersonaController::class);

    // CRUD de mascotas
    Route::apiResource('mascotas', MascotaController::class);

    // Consulta avanzada: obtener persona con sus mascotas
    // Route::get('/personas/{id}/mascotas', [PersonaController::class, 'conMascotas']);
});
