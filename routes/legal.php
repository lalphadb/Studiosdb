<?php

use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Légales - Conformité Loi 25
|--------------------------------------------------------------------------
*/

Route::controller(LegalController::class)->group(function () {
    Route::get('/politique-de-confidentialite', 'privacy')->name('privacy');
    Route::get('/conditions-utilisation', 'terms')->name('terms');
    Route::get('/contact', 'contact')->name('contact');
});

// Alias pour compatibilité
Route::get('/privacy-policy', [LegalController::class, 'privacy'])->name('privacy-policy');

// Route spécifique Loi 25
Route::get('/loi-25', function() {
    return view('legal.loi25');
})->name('loi-25');
