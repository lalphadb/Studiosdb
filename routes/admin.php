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
use App\Http\Controllers\Admin\InscriptionCoursController;
use App\Http\Controllers\Admin\PortesOuvertesController;
use App\Http\Controllers\Admin\AuthLogController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Redirection par défaut vers dashboard
    Route::get('/', function() { return redirect()->route('admin.dashboard'); });
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats/api', [DashboardController::class, 'apiStats'])->name('stats.api');
    
    // Resources standard
    Route::resource('ecoles', EcoleController::class);
    Route::resource('membres', MembresController::class);
    Route::resource('cours', CoursController::class);
    Route::resource('sessions', SessionController::class);
    Route::resource('inscriptions', InscriptionCoursController::class);
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
    Route::get('membres/pending', [MembresController::class, 'pending'])
        ->name('membres.pending');
    Route::post('membres/bulk-approve', [MembresController::class, 'bulkApprove'])
        ->name('membres.bulk-approve');
    
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
    
    // Actions spéciales Inscriptions
    Route::patch('inscriptions/{inscription}/statut', [InscriptionCoursController::class, 'updateStatut'])
        ->name('inscriptions.update-statut');
    Route::post('inscriptions/bulk-action', [InscriptionCoursController::class, 'bulkAction'])
        ->name('inscriptions.bulk-action');
    
    // Gestion des Portes Ouvertes (Admin)
    Route::prefix('portes-ouvertes')->name('portes-ouvertes.')->group(function () {
        Route::get('/', [PortesOuvertesController::class, 'index'])->name('index');
        Route::get('/create', [PortesOuvertesController::class, 'create'])->name('create');
        Route::post('/', [PortesOuvertesController::class, 'store'])->name('store');
        Route::get('/{porteOuverte}/edit', [PortesOuvertesController::class, 'edit'])->name('edit');
        Route::patch('/{porteOuverte}', [PortesOuvertesController::class, 'update'])->name('update');
        Route::delete('/{porteOuverte}', [PortesOuvertesController::class, 'destroy'])->name('destroy');
        Route::patch('/{porteOuverte}/toggle', [PortesOuvertesController::class, 'toggle'])->name('toggle');
        
        // Inscriptions aux portes ouvertes
        Route::get('/{porteOuverte}/inscriptions', [PortesOuvertesController::class, 'inscriptions'])
            ->name('inscriptions');
        Route::get('/inscriptions/export', [PortesOuvertesController::class, 'exportInscriptions'])
            ->name('inscriptions.export');
    });
    
    // Logs d'authentification (Loi 25)
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/auth', [AuthLogController::class, 'index'])->name('auth');
        Route::get('/auth/export', [AuthLogController::class, 'export'])->name('auth.export');
        Route::get('/auth/{authLog}', [AuthLogController::class, 'show'])->name('auth.show');
    });
    
    // Exports
    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('membres', [MembresController::class, 'export'])->name('membres');
        Route::get('presences', [PresenceController::class, 'export'])->name('presences');
        Route::get('ecoles', [EcoleController::class, 'export'])->name('ecoles');
        Route::get('sessions', [SessionController::class, 'export'])->name('sessions');
        Route::get('seminaires', [SeminaireController::class, 'export'])->name('seminaires');
        Route::get('inscriptions', [InscriptionCoursController::class, 'export'])->name('inscriptions');
    });
    
    // Rapports et statistiques
    Route::prefix('rapports')->name('rapports.')->group(function () {
        Route::get('/retention', [DashboardController::class, 'retentionReport'])->name('retention');
        Route::get('/presences', [DashboardController::class, 'presencesReport'])->name('presences');
        Route::get('/inscriptions', [DashboardController::class, 'inscriptionsReport'])->name('inscriptions');
    });
    
    // Configuration système (pour superadmin uniquement)
    Route::middleware('role:superadmin')->prefix('config')->name('config.')->group(function () {
    // Redirection par défaut vers dashboard
    Route::get('/', function() { return redirect()->route('admin.dashboard'); });
        Route::get('/', function() {
            return view('admin.config.index');
        })->name('index');
        Route::post('/maintenance', function() {
            // Logique pour activer/désactiver le mode maintenance
        })->name('maintenance');
    });
});
