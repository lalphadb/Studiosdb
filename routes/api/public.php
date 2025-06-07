<?php

use App\Http\Controllers\PortesOuvertesPublicController as PortesOuvertesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes Publiques
|--------------------------------------------------------------------------
*/

// API pour les portes ouvertes
Route::prefix('portes-ouvertes')->group(function () {
    Route::get('dates/{ecole}', [PortesOuvertesController::class, 'getDates']);
    Route::get('ecoles-actives', [PortesOuvertesController::class, 'getEcolesActives']);
});
