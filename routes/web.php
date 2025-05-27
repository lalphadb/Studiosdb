<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\EcoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MembreController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\SeminaireController;
use App\Http\Controllers\Auth\LoginController;

// =============================================
// ROUTES PUBLIQUES
// =============================================
Route::get('/', fn() => redirect()->route('login'));

// =============================================
// AUTHENTIFICATION
// =============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =============================================
// DASHBOARD SÉCURISÉ
// =============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// =============================================
// ROUTES PROTÉGÉES PAR AUTHENTIFICATION  
// =============================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // -------------------------------------------
    // GESTION DES MEMBRES
    // -------------------------------------------
    Route::resource('membres', MembreController::class);
    Route::get('/membres/attente', [MembreController::class, 'attente'])->name('membres.attente');
    Route::patch('/membres/{membre}/approve', [MembreController::class, 'approve'])->name('membres.approve');
    Route::patch('/membres/{membre}/reject', [MembreController::class, 'reject'])->name('membres.reject');

    // Séminaires - Association membre
    Route::post('/membres/{membre}/seminaire', [MembreController::class, 'ajouterSeminaire'])
        ->name('membres.seminaire.inscrire');
    Route::delete('/membres/{membre}/seminaire/{seminaire}', [MembreController::class, 'retirerSeminaire'])
        ->name('membres.seminaire.retirer');

    // Ceintures - Association membre
    Route::post('/membres/{membre}/ceinture', [MembreController::class, 'ajouterCeinture'])
        ->name('membres.ceinture.ajouter');
    Route::delete('/membres/{membre}/ceinture/{ceinture}', [MembreController::class, 'retirerCeinture'])
        ->name('membres.ceinture.retirer');

    // -------------------------------------------
    // GESTION DES COURS ET SESSIONS
    // -------------------------------------------
    
    // Sessions de cours
    Route::resource('sessions', SessionController::class);
    Route::post('/sessions/{session}/duplicate', [SessionController::class, 'duplicate'])->name('sessions.duplicate');
    Route::patch('/sessions/{session}/activer-reinscriptions', [SessionController::class, 'activerReinscriptions'])->name('sessions.activer-reinscriptions');

    // Cours
    Route::resource('cours', CoursController::class);
    Route::post('/cours/{cours}/duplicate', [CoursController::class, 'duplicate'])->name('cours.duplicate');
    
    // Gestion des inscriptions aux cours
    Route::get('/cours/{cours}/inscriptions', [CoursController::class, 'inscriptions'])->name('cours.inscriptions');
    Route::post('/cours/{cours}/inscriptions', [CoursController::class, 'storeInscription'])->name('cours.inscriptions.store');
    Route::delete('/cours/{cours}/inscriptions/{inscription}', [CoursController::class, 'destroyInscription'])->name('cours.inscriptions.destroy');

    // -------------------------------------------
    // GESTION DES ÉCOLES
    // -------------------------------------------
    Route::resource('ecoles', EcoleController::class);
    Route::patch('/ecoles/{ecole}/toggle-status', [EcoleController::class, 'toggleStatus'])->name('ecoles.toggle-status');

    // -------------------------------------------
    // GESTION DES PRÉSENCES
    // -------------------------------------------
    Route::resource('presences', PresenceController::class);
    
    // Présences par cours
    Route::get('/cours/{cours}/presences', [PresenceController::class, 'parCours'])->name('presences.cours');
    Route::post('/cours/{cours}/presences', [PresenceController::class, 'enregistrerPresences'])->name('presences.enregistrer');
    
    // QR Code pour présences
    Route::get('/presences/qr/{cours}', [PresenceController::class, 'qrCode'])->name('presences.qr');
    Route::post('/presences/scan', [PresenceController::class, 'scanQr'])->name('presences.scan');

    // -------------------------------------------
    // GESTION DES SÉMINAIRES
    // -------------------------------------------
    Route::resource('seminaires', SeminaireController::class);
    Route::post('/seminaires/{seminaire}/inscrire', [SeminaireController::class, 'inscrireMembre'])->name('seminaires.inscrire');
    Route::delete('/seminaires/{seminaire}/desinscrire/{membre}', [SeminaireController::class, 'desinscrireMembre'])->name('seminaires.desinscrire');

    // -------------------------------------------
    // EXPORTS (PDF / Excel)
    // -------------------------------------------
    Route::prefix('export')->name('export.')->group(function () {
        // Exports membres
        Route::get('/membres/excel', [ExportController::class, 'exportMembresExcel'])->name('membres.excel');
        Route::get('/membres/pdf', [ExportController::class, 'exportMembresPdf'])->name('membres.pdf');
        
        // Exports cours et sessions
        Route::get('/cours/excel', [ExportController::class, 'exportCoursExcel'])->name('cours.excel');
        Route::get('/sessions/excel', [ExportController::class, 'exportSessionsExcel'])->name('sessions.excel');
        
        // Exports présences
        Route::get('/presences/excel', [ExportController::class, 'exportPresencesExcel'])->name('presences.excel');
        Route::get('/presences/pdf/{cours}', [ExportController::class, 'exportPresencesPdf'])->name('presences.pdf');
    });

    // -------------------------------------------
    // GESTION DES UTILISATEURS (SuperAdmin uniquement)
    // -------------------------------------------
    Route::middleware(['can:manage-users'])->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::patch('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });

    // -------------------------------------------
    // ROUTES API INTERNES
    // -------------------------------------------
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/membres/search', [MembreController::class, 'search'])->name('membres.search');
        Route::get('/cours/search', [CoursController::class, 'search'])->name('cours.search');
        Route::get('/ecoles/list', [EcoleController::class, 'apiList'])->name('ecoles.list');
        Route::get('/stats/dashboard', [DashboardController::class, 'apiStats'])->name('stats.dashboard');
    });
});

// =============================================
// ROUTES DE DEBUG (À SUPPRIMER EN PRODUCTION)
// =============================================
if (config('app.debug')) {
    Route::get('/quick-login', function() {
        $user = \App\Models\User::where('email', 'louis@4lb.ca')->first();
        if (!$user) {
            $user = \App\Models\User::where('role', 'superadmin')->first();
        }
        if (!$user) {
            $user = \App\Models\User::where('role', 'admin')->first();
        }
        
        if ($user) {
            \Auth::login($user, true);
            return redirect('/dashboard')->with('success', 'Connexion automatique réussie');
        }
        
        return 'Aucun utilisateur trouvé pour la connexion automatique';
    });
}
