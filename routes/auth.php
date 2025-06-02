<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    
    // Routes temporaires pour éviter les erreurs
    Route::get('register', function() {
        return view('auth.login'); // Rediriger vers login pour l'instant
    })->name('register');
    
    Route::post('register', function() {
        return redirect()->route('login')->with('info', 'L\'inscription sera bientôt disponible.');
    });
    
    Route::get('forgot-password', function() {
        return redirect()->route('login')->with('info', 'La récupération de mot de passe sera bientôt disponible.');
    })->name('password.request');
    
    Route::post('portes-ouvertes/register', function() {
        return redirect()->route('login')->with('info', 'Les inscriptions aux portes ouvertes seront bientôt disponibles.');
    })->name('portes-ouvertes.register');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});
