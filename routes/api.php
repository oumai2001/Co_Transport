<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\VehiculeController;
use Illuminate\Support\Facades\Route;

// Route de test
Route::get('/test', function () {
    return response()->json(['message' => 'API CoTransport fonctionne']);
});

Route::get('/hello', function () {
    return response()->json(['message' => 'Hello API']);
});
// Routes publiques
Route::post('/login', [AuthController::class, 'login']);
// Route d'inscription
Route::post('/register', [AuthController::class, 'register']);
Route::get('/trajets', [TrajetController::class, 'index']);
Route::get('/trajets/{id}', [TrajetController::class, 'show']);
Route::get('/villes', [VilleController::class, 'index']);

// Routes protégées (nécessitent authentification)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Passager
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy']);
    Route::get('/mes-reservations', [ReservationController::class, 'mesReservations']);
    
    // Favoris
    Route::post('/favoris/{trajet_id}', [FavoriController::class, 'store']);
    Route::delete('/favoris/{id}', [FavoriController::class, 'destroy']);
    Route::get('/mes-favoris', [FavoriController::class, 'index']);
    
    // Conducteur
    Route::post('/trajets', [TrajetController::class, 'store']);
    Route::put('/trajets/{id}', [TrajetController::class, 'update']);
    Route::delete('/trajets/{id}', [TrajetController::class, 'destroy']);
    Route::get('/mes-trajets', [TrajetController::class, 'mesTrajets']);
    
    // Véhicules
    Route::get('/mes-vehicules', [VehiculeController::class, 'index']);
    Route::post('/vehicules', [VehiculeController::class, 'store']);
    Route::put('/vehicules/{id}', [VehiculeController::class, 'update']);
    Route::delete('/vehicules/{id}', [VehiculeController::class, 'destroy']);
});