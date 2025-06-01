<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EcoleController;
use App\Http\Controllers\Admin\MembresController;
use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\InscriptionController;
use App\Http\Controllers\Admin\SeminaireController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// PROBLÈME ICI : 'active' devrait être un middleware personnalisé
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats/api', [DashboardController::class, 'apiStats'])->name('stats.api');
    
});

    // Resources standard
    Route::resource('ecoles', EcoleController::class);
    Route::resource('membres', MembresController::class);
    Route::resource('cours', CoursController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('inscriptions', InscriptionController::class);
    Route::resource('seminaires', SeminaireController::class);
    Route::resource('presences', PresenceController::class)->except(['show']);
    
    // Actions spéciales Écoles
    Route::patch('ecoles/{ecole}/toggle-status', [EcoleController::class, 'toggleStatus'])
        ->name('ecoles.toggle-status');
    
    // Actions spéciales Membres
    Route::patch('membres/{membre}/approve', [MembresController::class, 'approve'])
        ->name('membres.approve');
    Route::patch('membres/{membre}/toggle-status', [MembresController::class, 'toggleStatus'])
        ->name('membres.toggle-status');
    
    // Actions spéciales Cours
    Route::post('cours/{cours}/duplicate', [CoursController::class, 'duplicate'])
        ->name('cours.duplicate');
    Route::patch('cours/{cours}/toggle-status', [CoursController::class, 'toggleStatus'])
        ->name('cours.toggle-status');
    
    // Actions spéciales Sessions
    Route::patch('sessions/{session}/toggle-active', [SessionController::class, 'toggleActive'])
        ->name('sessions.toggle-active');
    Route::patch('sessions/{session}/toggle-inscriptions', [SessionController::class, 'toggleInscriptions'])
        ->name('sessions.toggle-inscriptions');
    
    // Actions spéciales Présences
    Route::get('presences/cours/{cours}', [PresenceController::class, 'byCours'])
        ->name('presences.by-cours');
    Route::post('presences/bulk-update', [PresenceController::class, 'bulkUpdate'])
        ->name('presences.bulk-update');
    
    // Exports
    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('membres', [MembresController::class, 'export'])->name('membres');
        Route::get('presences', [PresenceController::class, 'export'])->name('presences');
        Route::get('ecoles', [EcoleController::class, 'export'])->name('ecoles');
        Route::get('sessions', [SessionController::class, 'export'])->name('sessions');
        Route::get('seminaires', [SeminaireController::class, 'export'])->name('seminaires');
    });
