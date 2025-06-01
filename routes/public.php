<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Pages légales (Loi 25)
Route::view('/politique-confidentialite', 'legal.privacy-policy')->name('privacy-policy');
Route::view('/conditions-utilisation', 'legal.terms')->name('terms');
Route::view('/avis-collecte', 'legal.data-collection')->name('data-collection');
Route::view('/droits-acces', 'legal.access-rights')->name('access-rights');

// Contact
Route::view('/contact', 'public.contact')->name('contact');

// Pour l'instant, on commente la soumission de contact car le contrôleur n'existe pas encore
// Route::post('/contact', [ContactController::class, 'submit'])
//     ->name('contact.submit')
//     ->middleware('throttle:3,1');
