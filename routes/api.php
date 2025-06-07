<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for StudiosDB avec préfixe de nom
Route::prefix('v1')->middleware('auth:sanctum')->name('api.')->group(function () {
    // Écoles API endpoints
    Route::apiResource('ecoles', App\Http\Controllers\Api\EcoleController::class);

    // Membres API endpoints
    Route::apiResource('membres', App\Http\Controllers\Api\MembreController::class);

    // Cours API endpoints
    Route::apiResource('cours', App\Http\Controllers\Api\CoursController::class);

    // Présences API endpoints
    Route::apiResource('presences', App\Http\Controllers\Api\PresenceController::class);

    // Sessions API endpoints
    Route::apiResource('sessions', App\Http\Controllers\Api\SessionController::class);

    // Ceintures API endpoints
    Route::apiResource('ceintures', App\Http\Controllers\Api\CeintureController::class);
});

// Public API endpoints (no authentication required)
Route::prefix('public')->name('api.public.')->group(function () {
    // Public endpoints for mobile app or external integrations
    Route::get('ecoles', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Public API endpoint for Studios Unis',
        ]);
    })->name('ecoles');
});
// Inclure les routes API publiques
require __DIR__.'/api/public.php';
