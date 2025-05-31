<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EcoleController;
use App\Http\Controllers\Admin\MembresController;
use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\SeminaireController;
use App\Http\Controllers\Admin\CeintureController;
use App\Http\Controllers\Admin\PorteOuverteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Configuration des routes principales de l'application StudiosDB
*/

// Redirection intelligente depuis la racine
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
})->name('home');

// Routes d'authentification utilisant les contrôleurs existants
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Routes administratives protégées
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    // Tableau de bord principal avec API
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/api/stats', [DashboardController::class, 'apiStats'])->name('api.stats');
    
    // Module ÉCOLES - Gestion complète
    Route::resource('ecoles', EcoleController::class);
    Route::patch('ecoles/{ecole}/toggle-status', [EcoleController::class, 'toggleStatus'])
        ->name('ecoles.toggle-status');
    
    // Module MEMBRES - Gestion complète avec MembresController corrigé
    Route::resource('membres', MembresController::class);
    Route::patch('membres/{membre}/approve', [MembresController::class, 'approve'])
        ->name('membres.approve');
    Route::patch('membres/{membre}/toggle-status', [MembresController::class, 'toggleStatus'])
        ->name('membres.toggle-status');
    
    // Module COURS - Gestion complète
    Route::resource('cours', CoursController::class);
    Route::post('cours/{cours}/duplicate', [CoursController::class, 'duplicate'])
        ->name('cours.duplicate');
    Route::patch('cours/{cours}/toggle-status', [CoursController::class, 'toggleStatus'])
        ->name('cours.toggle-status');
    
    // Module INSCRIPTIONS - Gestion des inscriptions aux cours
    Route::resource('inscriptions', \App\Http\Controllers\Admin\InscriptionController::class);
    
    // Module SESSIONS - Gestion complète
    Route::resource('sessions', SessionController::class);
    Route::patch('sessions/{session}/toggle-active', [SessionController::class, 'toggleActive'])
        ->name('sessions.toggle-active');
    Route::patch('sessions/{session}/toggle-inscriptions', [SessionController::class, 'toggleInscriptions'])
        ->name('sessions.toggle-inscriptions');
    
    // Module PRÉSENCES - Gestion avancée avec QR codes
    Route::resource('presences', PresenceController::class)->except(['show']);
    Route::get('presences/cours/{cours}', [PresenceController::class, 'byCours'])
        ->name('presences.by-cours');
    Route::post('presences/bulk-update', [PresenceController::class, 'bulkUpdate'])
        ->name('presences.bulk-update');
    Route::get('presences/qr/{cours}', [PresenceController::class, 'showQR'])
        ->name('presences.qr');
    Route::post('presences/scan', [PresenceController::class, 'scanQR'])
        ->name('presences.scan');
    
    // Module SÉMINAIRES - Gestion avec participants
    Route::resource('seminaires', SeminaireController::class);
    Route::post('seminaires/{seminaire}/members', [SeminaireController::class, 'addMember'])
        ->name('seminaires.add-member');
    Route::delete('seminaires/{seminaire}/members/{membre}', [SeminaireController::class, 'removeMember'])
        ->name('seminaires.remove-member');
    
    // Module CEINTURES - Système de progression
    Route::resource('ceintures', CeintureController::class);
    Route::post('ceintures/assign', [CeintureController::class, 'assignToMember'])
        ->name('ceintures.assign');
    Route::get('ceintures/progression/{membre}', [CeintureController::class, 'progression'])
        ->name('ceintures.progression');
    
    // Module PORTES OUVERTES - Événements publics
    Route::resource('portes-ouvertes', PorteOuverteController::class);
    Route::patch('portes-ouvertes/{porteOuverte}/toggle-active', [PorteOuverteController::class, 'toggleActive'])
        ->name('portes-ouvertes.toggle-active');
    
    // Fonctionnalités d'export sécurisées
    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('membres', [MembresController::class, 'export'])->name('membres');
        Route::get('presences', [PresenceController::class, 'export'])->name('presences');
        Route::get('ecoles', [EcoleController::class, 'export'])->name('ecoles');
        Route::get('sessions', [SessionController::class, 'export'])->name('sessions');
        Route::get('seminaires', [SeminaireController::class, 'export'])->name('seminaires');
    });
});

// Interface publique pour les inscriptions avec limitation de débit
Route::middleware('throttle:10,1')->group(function () {
    Route::get('/inscription', [PorteOuverteController::class, 'publicForm'])->name('inscription.public');
    Route::post('/inscription', [PorteOuverteController::class, 'submitPublicForm'])->name('inscription.submit');
});

// Routes API publiques avec limitation de débit
Route::middleware(['throttle:api'])->prefix('api/v1')->name('api.')->group(function () {
    Route::get('ecoles/publiques', [EcoleController::class, 'publicList'])->name('ecoles.public');
    Route::get('sessions/actives', [SessionController::class, 'activeList'])->name('sessions.active');
});

// Routes Loi 25
Route::get('/politique-confidentialite', function () {
    return view('politique');
})->name('privacy-policy');

Route::get('/conditions-utilisation', function () {
    return redirect()->route('privacy-policy')->with('section', 'conditions');
})->name('terms');

Route::get('/avis-collecte', function () {
    return redirect()->route('privacy-policy')->with('section', 'collecte');
})->name('data-collection');

Route::get('/droits-acces', function () {
    return redirect()->route('privacy-policy')->with('section', 'droits');
})->name('access-rights');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
