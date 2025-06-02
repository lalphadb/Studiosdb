<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes - STUDIOSUNISDB
|--------------------------------------------------------------------------
*/

// Redirection automatique selon l'état de connexion
Route::get('/', [HomeController::class, 'index'])->name('home');

// Inclure les routes d'authentification
require __DIR__.'/auth.php';

// Inclure les routes admin
require __DIR__.'/admin.php';

// Inclure les routes publiques
require __DIR__.'/public.php';

// Page 404 personnalisée
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
