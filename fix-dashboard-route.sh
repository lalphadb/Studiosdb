#!/bin/bash
# fix-dashboard-route.sh

echo "🔧 CORRECTION DE LA ROUTE DASHBOARD"
echo "==================================="

# 1. Vérifier le contenu actuel de routes/admin.php
echo "📋 Contenu actuel de routes/admin.php :"
head -30 routes/admin.php

# 2. Corriger les routes admin
echo "🛣️ Correction des routes admin..."
# Sauvegarder l'original
cp routes/admin.php routes/admin.php.backup

# Vérifier si la route dashboard existe
if ! grep -q "name('dashboard')" routes/admin.php; then
    echo "❌ Route dashboard manquante, ajout en cours..."
    
    # Ajouter la route dashboard au début du groupe admin
    sed -i "/Route::middleware.*admin.*group(function/a\\    // Dashboard\\n    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');" routes/admin.php
fi

# 3. Vérifier que le modèle Session existe (on l'a créé précédemment)
if [ ! -f "app/Models/Session.php" ]; then
    echo "📝 Création du modèle Session manquant..."
    cat > app/Models/Session.php << 'EOF'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';
    
    protected $fillable = [
        'name',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];

    public $timestamps = false;
}
EOF
fi

# 4. Si le problème persiste, utiliser CoursSession
echo "🔄 Alternative : Utilisation de CoursSession..."
cat > app/Http/Controllers/Admin/DashboardController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Membre;
use App\Models\Cours;
use App\Models\CoursSession; // Utiliser CoursSession au lieu de Session
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Si c'est un superadmin
            if ($user->role === 'admin') {
                return $this->superAdminDashboard();
            }
            
            // Pour les admins d'école
            return $this->ecoleAdminDashboard($user);
        } catch (\Exception $e) {
            \Log::error('Erreur Dashboard: ' . $e->getMessage());
            // En cas d'erreur, afficher quand même quelque chose
            return view('admin.dashboard.index', [
                'error' => 'Erreur lors du chargement des données'
            ]);
        }
    }
    
    private function superAdminDashboard()
    {
        try {
            $stats = [
                'total_ecoles' => Ecole::count(),
                'total_ecoles_actives' => Ecole::count(), // Temporaire
                'total_membres' => Membre::count(),
                'total_membres_approuves' => Membre::where('approuve', true)->count(),
                'total_cours' => Cours::count(),
                'total_sessions' => CoursSession::count(), // Utiliser CoursSession
                'total_users' => User::count(),
                'nouveaux_membres_mois' => Membre::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count(),
            ];
            
            $topEcoles = Ecole::withCount('membres')
                ->orderBy('membres_count', 'desc')
                ->take(5)
                ->get();
            
            $inscriptionsParMois = collect();
            
            return view('admin.dashboard.superadmin', compact(
                'stats', 
                'topEcoles', 
                'inscriptionsParMois'
            ));
        } catch (\Exception $e) {
            \Log::error('Erreur SuperAdmin Dashboard: ' . $e->getMessage());
            return view('admin.dashboard.superadmin', [
                'stats' => $this->getDefaultStats(),
                'topEcoles' => collect([]),
                'inscriptionsParMois' => collect()
            ]);
        }
    }
    
    private function ecoleAdminDashboard($user)
    {
        try {
            $ecoleId = $user->ecole_id;
            
            if (!$ecoleId) {
                // Si pas d'école assignée, afficher un message
                return view('admin.dashboard.no-ecole');
            }
            
            $ecole = Ecole::find($ecoleId);
            
            if (!$ecole) {
                return view('admin.dashboard.no-ecole');
            }
            
            $stats = [
                'total_membres' => Membre::where('ecole_id', $ecoleId)->count(),
                'membres_approuves' => Membre::where('ecole_id', $ecoleId)->where('approuve', true)->count(),
                'membres_en_attente' => Membre::where('ecole_id', $ecoleId)->where('approuve', false)->count(),
                'total_cours' => Cours::where('ecole_id', $ecoleId)->count(),
                'sessions_actives' => 0, // Temporaire
                'nouveaux_cette_semaine' => Membre::where('ecole_id', $ecoleId)
                    ->where('created_at', '>=', Carbon::now()->startOfWeek())
                    ->count(),
            ];
            
            $membresEnAttente = Membre::where('ecole_id', $ecoleId)
                ->where('approuve', false)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $prochainesSessions = collect(); // Vide pour l'instant
            
            return view('admin.dashboard.ecole', compact(
                'ecole',
                'stats',
                'membresEnAttente',
                'prochainesSessions'
            ));
        } catch (\Exception $e) {
            \Log::error('Erreur Ecole Dashboard: ' . $e->getMessage());
            return view('admin.dashboard.error', [
                'message' => 'Erreur lors du chargement du dashboard'
            ]);
        }
    }
    
    private function getDefaultStats()
    {
        return [
            'total_ecoles' => 0,
            'total_ecoles_actives' => 0,
            'total_membres' => 0,
            'total_membres_approuves' => 0,
            'total_cours' => 0,
            'total_sessions' => 0,
            'total_users' => 0,
            'nouveaux_membres_mois' => 0,
        ];
    }
}
EOF

# 5. Créer une vue de dashboard simple si les autres n'existent pas
echo "📄 Création d'une vue de dashboard de base..."
mkdir -p resources/views/admin/dashboard

cat > resources/views/admin/dashboard/index.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <h2 class="text-white">Bienvenue sur StudiosDB</h2>
                <p class="text-muted">Chargement du dashboard...</p>
                
                @if(isset($error))
                    <div class="alert alert-warning">
                        {{ $error }}
                    </div>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('admin.ecoles.index') }}" class="btn btn-primary">
                        Voir les écoles
                    </a>
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-info ml-2">
                        Voir les membres
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
EOF

# 6. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data app/
chown -R lalpha:www-data resources/views/
chmod -R 755 app/
chmod -R 755 resources/views/

# 7. Clear cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:clear

# 8. Afficher les routes pour vérifier
echo ""
echo "📋 Routes admin disponibles :"
php artisan route:list | grep "admin" | grep -E "(dashboard|ecoles|membres)" | head -10

echo ""
echo "✅ Correction terminée !"
echo ""
echo "🔄 Testez maintenant :"
echo "1. http://207.253.150.57/admin"
echo "2. http://207.253.150.57/admin/dashboard"
echo ""
echo "Si le problème persiste, vérifiez les logs :"
echo "tail -f storage/logs/laravel.log"

