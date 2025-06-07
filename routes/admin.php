<?php

use App\Http\Controllers\Admin\CoursController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EcoleController;
use App\Http\Controllers\Admin\InscriptionCoursController;
use App\Http\Controllers\Admin\MembresController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\SeminaireController;
use App\Http\Controllers\Admin\SessionController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Resources
Route::resource('ecoles', EcoleController::class);
Route::resource('membres', MembresController::class);
Route::resource('cours', CoursController::class);
Route::resource('sessions', SessionController::class);
Route::resource('inscriptions', InscriptionCoursController::class);
Route::resource('seminaires', SeminaireController::class);
Route::resource('presences', PresenceController::class)->except(['show']);

// Actions spéciales Membres
Route::patch('membres/{membre}/approve', [MembresController::class, 'approve'])->name('membres.approve');
Route::patch('membres/{membre}/toggle-status', [MembresController::class, 'toggleStatus'])->name('membres.toggle-status');

// Actions spéciales Cours
Route::post('cours/{cours}/duplicate', [CoursController::class, 'duplicate'])->name('cours.duplicate');
Route::patch('cours/{cours}/toggle-status', [CoursController::class, 'toggleStatus'])->name('cours.toggle-status');

// Actions spéciales Inscriptions
Route::patch('inscriptions/{inscription}/statut', [InscriptionCoursController::class, 'updateStatut'])->name('inscriptions.update-statut');
Route::post('inscriptions/bulk-action', [InscriptionCoursController::class, 'bulkAction'])->name('inscriptions.bulk-action');

// Rapports
Route::prefix('rapports')->name('rapports.')->group(function () {
    Route::get('/', [DashboardController::class, 'rapportsIndex'])->name('index');
    Route::get('/retention', [DashboardController::class, 'retentionReport'])->name('retention');
    Route::get('/presences', [DashboardController::class, 'presencesReport'])->name('presences');
    Route::get('/inscriptions', [DashboardController::class, 'inscriptionsReport'])->name('inscriptions');
});

// Thèmes
Route::post('themes/switch', function () {
    session(['theme' => request('theme', 'aurora-grey')]);

    return back();
})->name('themes.switch');



// Gestion des utilisateurs
Route::middleware(['role:superadmin|admin'])->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::patch('users/{user}/activate', [App\Http\Controllers\Admin\UserController::class, 'activate'])->name('users.activate');
});
