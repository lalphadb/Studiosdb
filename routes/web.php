<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Dashboard avec redirection automatique selon le rôle
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->hasRole('superadmin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('admin.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes publiques
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// Routes des portes ouvertes publiques
Route::get('/portes-ouvertes/{ecole}', [App\Http\Controllers\PortesOuvertesPublicController::class, 'show'])->name('portes-ouvertes.show');
Route::post('/portes-ouvertes/{ecole}/register', [App\Http\Controllers\PortesOuvertesPublicController::class, 'register'])->name('portes-ouvertes.register');

// Groupe des routes légales
require __DIR__.'/legal.php';

// Routes d'administration (protégées par auth et verified)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));

// Routes d'authentification
require __DIR__.'/auth.php';
