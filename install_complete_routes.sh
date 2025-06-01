#!/bin/bash
# install_complete_routes.sh

echo "=== Installation complète de la structure de routes ==="

# 1. Restaurer d'abord l'ancien web.php pour éviter les erreurs
if [ -f routes/web.php.backup.* ]; then
    echo "Restauration du fichier de sauvegarde..."
    cp routes/web.php.backup.* routes/web.php
fi

# 2. Créer TOUS les fichiers de routes EN MÊME TEMPS

echo "Création de routes/auth.php..."
cat > routes/auth.php << 'EOF'
<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('logout/confirm', [AuthController::class, 'logoutConfirm'])->name('logout.confirm');
    
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', function() { return view('profile.index'); })->name('index');
        Route::get('/login-history', [AuthController::class, 'loginHistory'])->name('login-history');
    });
});
EOF

echo "Création de routes/admin.php..."
cat > routes/admin.php << 'EOF'
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

Route::middleware(['auth', 'active'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stats/api', [DashboardController::class, 'apiStats'])->name('stats.api');
    
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
});
EOF

echo "Création de routes/public.php..."
cat > routes/public.php << 'EOF'
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
EOF

echo "Création de routes/web.php principal..."
cat > routes/web.php << 'EOF'
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - STUDIOSUNISDB
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
})->name('home');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/public.php';

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
EOF

# 3. Créer les contrôleurs manquants de base
echo "Création des contrôleurs manquants..."

# CeintureController
if [ ! -f "app/Http/Controllers/Admin/CeintureController.php" ]; then
    cat > app/Http/Controllers/Admin/CeintureController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CeintureController extends Controller
{
    public function index()
    {
        return view('admin.ceintures.index', [
            'message' => 'Module Ceintures en développement'
        ]);
    }

    public function create() { return view('admin.ceintures.create'); }
    public function store(Request $request) { return redirect()->route('admin.ceintures.index'); }
    public function show(string $id) { return view('admin.ceintures.show'); }
    public function edit(string $id) { return view('admin.ceintures.edit'); }
    public function update(Request $request, string $id) { return redirect()->route('admin.ceintures.index'); }
    public function destroy(string $id) { return redirect()->route('admin.ceintures.index'); }
}
EOF
fi

# PorteOuverteController
if [ ! -f "app/Http/Controllers/Admin/PorteOuverteController.php" ]; then
    cat > app/Http/Controllers/Admin/PorteOuverteController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PorteOuverteController extends Controller
{
    public function index()
    {
        return view('admin.portes-ouvertes.index', [
            'message' => 'Module Portes Ouvertes en développement'
        ]);
    }
}
EOF
fi

# 4. Créer les vues minimales nécessaires
echo "Création des vues minimales..."

mkdir -p resources/views/admin/ceintures
mkdir -p resources/views/admin/portes-ouvertes
mkdir -p resources/views/auth
mkdir -p resources/views/legal
mkdir -p resources/views/public
mkdir -p resources/views/errors
mkdir -p resources/views/profile

# Vue index pour ceintures
cat > resources/views/admin/ceintures/index.blade.php << 'EOF'
<h1>Gestion des Ceintures</h1>
<p>{{ $message ?? 'Module en développement' }}</p>
EOF

# Vue index pour portes ouvertes
cat > resources/views/admin/portes-ouvertes/index.blade.php << 'EOF'
<h1>Gestion des Portes Ouvertes</h1>
<p>{{ $message ?? 'Module en développement' }}</p>
EOF

# Vue 404
cat > resources/views/errors/404.blade.php << 'EOF'
<!DOCTYPE html>
<html>
<head>
    <title>404 - Page non trouvée</title>
</head>
<body>
    <h1>404 - Page non trouvée</h1>
    <a href="{{ route('home') }}">Retour à l'accueil</a>
</body>
</html>
EOF

# 5. Nettoyer et vérifier
echo "Nettoyage et vérification..."
php artisan optimize:clear

echo ""
echo "=== Installation terminée avec succès! ==="
echo ""
echo "Vérification des routes:"
php artisan route:list --columns=method,uri,name | head -20

echo ""
echo "Pour tester:"
echo "php artisan serve"
echo "Puis visitez http://localhost:8000"
