<?php

use App\Http\Controllers\Auth\PortesOuvertesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes (No Auth Required)
|--------------------------------------------------------------------------
*/

// API pour les portes ouvertes
Route::prefix('portes-ouvertes')->group(function () {
    Route::get('dates/{ecole}', [PortesOuvertesController::class, 'getDates'])
        ->name('api.portes-ouvertes.dates');
    
    Route::get('ecoles-actives', [PortesOuvertesController::class, 'getEcolesActives'])
        ->name('api.portes-ouvertes.ecoles');
});
