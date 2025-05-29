<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EcoleController;
use App\Http\Controllers\Admin\MembreController;
use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\SeminaireController;
use App\Http\Controllers\Admin\CeintureController;
use App\Http\Controllers\Admin\PorteOuverteController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées (nécessitent une authentification)
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Routes des modules principaux
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // ÉCOLES - Routes complètes
        Route::resource('ecoles', EcoleController::class);
        Route::patch('ecoles/{ecole}/toggle-status', [EcoleController::class, 'toggleStatus'])
            ->name('ecoles.toggle-status');
        
        // MEMBRES - Routes complètes
        Route::resource('membres', MembreController::class);
        Route::patch('membres/{membre}/approve', [MembreController::class, 'approve'])
            ->name('membres.approve');
        Route::patch('membres/{membre}/toggle-status', [MembreController::class, 'toggleStatus'])
            ->name('membres.toggle-status');
        
        // COURS - Routes complètes
        Route::resource('cours', CoursController::class);
        Route::post('cours/{cours}/duplicate', [CoursController::class, 'duplicate'])
            ->name('cours.duplicate');
        Route::patch('cours/{cours}/toggle-status', [CoursController::class, 'toggleStatus'])
            ->name('cours.toggle-status');
        
        // SESSIONS - Routes complètes
        Route::resource('sessions', SessionController::class);
        Route::patch('sessions/{session}/toggle-active', [SessionController::class, 'toggleActive'])
            ->name('sessions.toggle-active');
        Route::patch('sessions/{session}/toggle-inscriptions', [SessionController::class, 'toggleInscriptions'])
            ->name('sessions.toggle-inscriptions');
        
        // PRÉSENCES - Routes complètes
        Route::resource('presences', PresenceController::class)->except(['show']);
        Route::get('presences/cours/{cours}', [PresenceController::class, 'byCours'])
            ->name('presences.by-cours');
        Route::post('presences/bulk-update', [PresenceController::class, 'bulkUpdate'])
            ->name('presences.bulk-update');
        Route::get('presences/qr/{cours}', [PresenceController::class, 'showQR'])
            ->name('presences.qr');
        Route::post('presences/scan', [PresenceController::class, 'scanQR'])
            ->name('presences.scan');
        
        // SÉMINAIRES - Routes complètes
        Route::resource('seminaires', SeminaireController::class);
        Route::post('seminaires/{seminaire}/members', [SeminaireController::class, 'addMember'])
            ->name('seminaires.add-member');
        Route::delete('seminaires/{seminaire}/members/{membre}', [SeminaireController::class, 'removeMember'])
            ->name('seminaires.remove-member');
        
        // CEINTURES - Routes complètes
        Route::resource('ceintures', CeintureController::class);
        Route::post('ceintures/assign', [CeintureController::class, 'assignToMember'])
            ->name('ceintures.assign');
        Route::get('ceintures/progression/{membre}', [CeintureController::class, 'progression'])
            ->name('ceintures.progression');
        
        // PORTES OUVERTES - Routes complètes
        Route::resource('portes-ouvertes', PorteOuverteController::class);
        Route::patch('portes-ouvertes/{porteOuverte}/toggle-active', [PorteOuverteController::class, 'toggleActive'])
            ->name('portes-ouvertes.toggle-active');
        
        // EXPORTS - Routes spéciales
        Route::get('exports/membres', [MembreController::class, 'export'])->name('exports.membres');
        Route::get('exports/presences', [PresenceController::class, 'export'])->name('exports.presences');
        Route::get('exports/ecoles', [EcoleController::class, 'export'])->name('exports.ecoles');
        
    });
});

// Routes publiques pour les portes ouvertes
Route::get('/inscription', [PorteOuverteController::class, 'publicForm'])->name('inscription.public');
Route::post('/inscription', [PorteOuverteController::class, 'submitPublicForm'])->name('inscription.submit');
