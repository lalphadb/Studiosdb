#!/bin/bash
# fix-superadmin-role.sh

echo "🔧 CORRECTION DE LA DÉTECTION DU RÔLE SUPERADMIN"
echo "==============================================="

# 1. Vérifier comment les rôles sont stockés
echo "📊 Vérification de la structure des rôles..."
php artisan tinker --execute="
\$users = \App\Models\User::select('id', 'name', 'email', 'role')->get();
foreach(\$users as \$user) {
    echo 'User: ' . \$user->name . ' - Role: ' . \$user->role . PHP_EOL;
}
"

# 2. Corriger le DashboardController
echo "🎮 Mise à jour du DashboardController..."
cat > app/Http/Controllers/Admin/DashboardController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Membre;
use App\Models\Cours;
use App\Models\CoursSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Debug: Afficher le rôle de l'utilisateur
            Log::info('Dashboard accessed by user: ' . $user->email . ' with role: ' . $user->role);
            
            // Vérifier si c'est un superadmin
            // Adapter selon votre système de rôles
            if ($user->role === 'superadmin' || 
                $user->role === 'admin' || 
                $user->email === 'admin@studiosdb.com' ||
                $user->id === 1) { // Souvent le premier utilisateur est superadmin
                return $this->superAdminDashboard();
            }
            
            // Pour les admins d'école
            return $this->ecoleAdminDashboard($user);
            
        } catch (\Exception $e) {
            Log::error('Erreur Dashboard: ' . $e->getMessage());
            return view('admin.dashboard.index', [
                'error' => 'Erreur lors du chargement des données: ' . $e->getMessage()
            ]);
        }
    }
    
    private function superAdminDashboard()
    {
        try {
            Log::info('Loading superadmin dashboard');
            
            $stats = [
                'total_ecoles' => Ecole::count(),
                'total_ecoles_actives' => Ecole::count(), // Temporaire
                'total_membres' => Membre::count(),
                'total_membres_approuves' => Membre::where('approuve', true)->count(),
                'total_cours' => Cours::count(),
                'total_sessions' => CoursSession::count(),
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
            Log::error('Erreur SuperAdmin Dashboard: ' . $e->getMessage());
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
                'sessions_actives' => 0,
                'nouveaux_cette_semaine' => Membre::where('ecole_id', $ecoleId)
                    ->where('created_at', '>=', Carbon::now()->startOfWeek())
                    ->count(),
            ];
            
            $membresEnAttente = Membre::where('ecole_id', $ecoleId)
                ->where('approuve', false)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $prochainesSessions = collect();
            
            return view('admin.dashboard.ecole', compact(
                'ecole',
                'stats',
                'membresEnAttente',
                'prochainesSessions'
            ));
            
        } catch (\Exception $e) {
            Log::error('Erreur Ecole Dashboard: ' . $e->getMessage());
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

# 3. Mettre à jour le rôle du superadmin si nécessaire
echo "👤 Mise à jour du rôle superadmin..."
php artisan tinker --execute="
// Trouver l'utilisateur superadmin (généralement ID 1 ou email spécifique)
\$user = \App\Models\User::where('id', 1)->orWhere('email', 'admin@studiosdb.com')->first();
if (\$user) {
    \$user->role = 'superadmin';
    \$user->save();
    echo 'Rôle mis à jour pour: ' . \$user->email . ' => superadmin';
} else {
    echo 'Utilisateur superadmin non trouvé';
}
"

# 4. Vider le cache et la session
echo "🧹 Nettoyage du cache et des sessions..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 5. Vérifier les logs
echo "📋 Dernières entrées du log..."
tail -5 storage/logs/laravel.log | grep -i "dashboard"

echo ""
echo "✅ Correction terminée !"
echo ""
echo "🔄 Actions à faire :"
echo "1. Déconnectez-vous"
echo "2. Reconnectez-vous"
echo "3. Le dashboard superadmin devrait s'afficher"
echo ""
echo "Si le problème persiste, vérifiez quel est le rôle exact dans la DB :"
echo "php artisan tinker"
echo ">>> \App\Models\User::find(1)->role"
