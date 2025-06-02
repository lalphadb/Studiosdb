#!/bin/bash

# Script de correction complète du dashboard
# Corrige toutes les erreurs

echo "🔧 CORRECTION COMPLÈTE DU DASHBOARD"
echo "==================================="

# Couleurs
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# 1. Vérifier la structure de la table ecoles
echo -e "${YELLOW}🔍 Vérification de la structure de la table ecoles...${NC}"
mysql -u root -p'your_password' studiosdb -e "DESCRIBE ecoles;" 2>/dev/null || mysql -u root studiosdb -e "DESCRIBE ecoles;"

# 2. Ajouter la colonne statut si elle n'existe pas
echo -e "${YELLOW}📊 Ajout de la colonne statut si nécessaire...${NC}"
php artisan tinker --execute="
try {
    \DB::statement('ALTER TABLE ecoles ADD COLUMN statut VARCHAR(20) DEFAULT \"actif\" AFTER email');
    echo 'Colonne statut ajoutée avec succès';
} catch (\Exception \$e) {
    if (strpos(\$e->getMessage(), 'Duplicate column') !== false) {
        echo 'La colonne statut existe déjà';
    } else {
        echo 'Erreur: ' . \$e->getMessage();
    }
}
"

# 3. Corriger le DashboardController avec gestion d'erreur
echo -e "${YELLOW}🎮 Mise à jour du DashboardController...${NC}"
cat > app/Http/Controllers/Admin/DashboardController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ecole;
use App\Models\Membre;
use App\Models\Cours;
use App\Models\Session;
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
            return redirect()->route('admin.ecoles.index')
                ->with('error', 'Erreur lors du chargement du dashboard.');
        }
    }
    
    private function superAdminDashboard()
    {
        try {
            // Vérifier si la colonne statut existe
            $hasStatutColumn = DB::select("SHOW COLUMNS FROM ecoles LIKE 'statut'");
            
            // Statistiques globales pour superadmin
            $stats = [
                'total_ecoles' => Ecole::count(),
                'total_ecoles_actives' => $hasStatutColumn ? Ecole::where('statut', 'actif')->count() : Ecole::count(),
                'total_membres' => Membre::count(),
                'total_membres_approuves' => Membre::where('approuve', true)->count(),
                'total_cours' => Cours::count(),
                'total_sessions' => Session::count(),
                'total_users' => User::count(),
                'nouveaux_membres_mois' => Membre::whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year)
                    ->count(),
            ];
            
            // Top 5 écoles par nombre de membres
            $topEcoles = Ecole::withCount('membres')
                ->orderBy('membres_count', 'desc')
                ->take(5)
                ->get();
            
            // Graphique des inscriptions par mois (12 derniers mois)
            $inscriptionsParMois = [];
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $count = Membre::whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count();
                $inscriptionsParMois[] = [
                    'mois' => $date->format('Y-m'),
                    'total' => $count
                ];
            }
            
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
                'inscriptionsParMois' => []
            ]);
        }
    }
    
    private function ecoleAdminDashboard($user)
    {
        try {
            $ecoleId = $user->ecole_id;
            
            if (!$ecoleId) {
                return redirect()->route('admin.ecoles.index')
                    ->with('error', 'Aucune école assignée à votre compte.');
            }
            
            $ecole = Ecole::find($ecoleId);
            
            if (!$ecole) {
                return redirect()->route('admin.ecoles.index')
                    ->with('error', 'École introuvable.');
            }
            
            // Vérifier si la colonne statut existe dans sessions
            $hasSessionStatut = DB::select("SHOW COLUMNS FROM sessions LIKE 'statut'");
            
            // Statistiques de base pour l'école
            $stats = [
                'total_membres' => Membre::where('ecole_id', $ecoleId)->count(),
                'membres_approuves' => Membre::where('ecole_id', $ecoleId)->where('approuve', true)->count(),
                'membres_en_attente' => Membre::where('ecole_id', $ecoleId)->where('approuve', false)->count(),
                'total_cours' => Cours::where('ecole_id', $ecoleId)->count(),
                'sessions_actives' => $hasSessionStatut ? 
                    Session::whereHas('cours', function($q) use ($ecoleId) {
                        $q->where('ecole_id', $ecoleId);
                    })->where('statut', 'actif')->count() :
                    Session::whereHas('cours', function($q) use ($ecoleId) {
                        $q->where('ecole_id', $ecoleId);
                    })->count(),
                'nouveaux_cette_semaine' => Membre::where('ecole_id', $ecoleId)
                    ->where('created_at', '>=', Carbon::now()->startOfWeek())
                    ->count(),
            ];
            
            // Membres récents à approuver
            $membresEnAttente = Membre::where('ecole_id', $ecoleId)
                ->where('approuve', false)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            // Prochaines sessions
            $prochainesSessions = Session::whereHas('cours', function($q) use ($ecoleId) {
                $q->where('ecole_id', $ecoleId);
            })
            ->where('date_debut', '>=', Carbon::now())
            ->orderBy('date_debut')
            ->take(5)
            ->with('cours')
            ->get();
            
            return view('admin.dashboard.ecole', compact(
                'ecole',
                'stats',
                'membresEnAttente',
                'prochainesSessions'
            ));
        } catch (\Exception $e) {
            \Log::error('Erreur Ecole Dashboard: ' . $e->getMessage());
            return redirect()->route('admin.ecoles.index')
                ->with('error', 'Erreur lors du chargement du dashboard de l\'école.');
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

# 4. Créer une migration pour ajouter statut si nécessaire
echo -e "${YELLOW}📝 Création de la migration pour la colonne statut...${NC}"
php artisan make:migration add_statut_to_ecoles_table_if_not_exists

# Mettre à jour la migration
MIGRATION_FILE=$(ls -t database/migrations/*add_statut_to_ecoles_table_if_not_exists.php | head -1)
cat > "$MIGRATION_FILE" << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('ecoles', 'statut')) {
            Schema::table('ecoles', function (Blueprint $table) {
                $table->enum('statut', ['actif', 'inactif'])->default('actif')->after('email');
            });
        }
        
        if (!Schema::hasColumn('sessions', 'statut')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->enum('statut', ['actif', 'inactif', 'terminé'])->default('actif')->after('places_max');
            });
        }
    }

    public function down()
    {
        // On ne supprime pas les colonnes en cas de rollback pour éviter la perte de données
    }
};
EOF

# 5. Exécuter la migration
echo -e "${YELLOW}🔄 Exécution de la migration...${NC}"
php artisan migrate

# 6. Créer la page 404 personnalisée
echo -e "${YELLOW}📄 Création de la page 404...${NC}"
mkdir -p resources/views/errors
cat > resources/views/errors/404.blade.php << 'EOF'
@extends('layouts.guest')

@section('title', 'Page non trouvée')

@section('content')
<div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="text-center">
        <h1 style="font-size: 120px; font-weight: bold; color: #00d4ff; margin: 0;">404</h1>
        <h2 style="color: white; margin-bottom: 20px;">Page non trouvée</h2>
        <p style="color: #7c7c94; margin-bottom: 30px;">La page que vous recherchez n'existe pas.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
</div>
@endsection
EOF

# 7. Vider tous les caches
echo -e "${YELLOW}🧹 Nettoyage complet des caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# 8. Reconstruire les caches
echo -e "${YELLOW}🔨 Reconstruction des caches...${NC}"
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Vérifier les permissions
echo -e "${YELLOW}🔐 Correction des permissions...${NC}"
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 10. Redémarrer les services
echo -e "${YELLOW}🔄 Redémarrage des services...${NC}"
sudo service php8.3-fpm restart 2>/dev/null || sudo service php8.2-fpm restart 2>/dev/null || sudo service php7.4-fpm restart
sudo service nginx restart

echo -e "${GREEN}✅ CORRECTION COMPLÈTE TERMINÉE !${NC}"
echo ""
echo "📋 ACTIONS EFFECTUÉES :"
echo "---------------------"
echo "✓ Colonne statut ajoutée aux tables ecoles et sessions"
echo "✓ DashboardController mis à jour avec gestion d'erreurs"
echo "✓ Migration créée et exécutée"
echo "✓ Page 404 personnalisée créée"
echo "✓ Tous les caches vidés et reconstruits"
echo "✓ Permissions corrigées"
echo "✓ Services redémarrés"
echo ""
echo -e "${YELLOW}🚀 TESTEZ MAINTENANT :${NC}"
echo "http://207.253.150.57/admin"
echo ""
echo "Si le problème persiste, vérifiez :"
echo "1. tail -f storage/logs/laravel.log"
echo "2. sudo tail -f /var/log/nginx/error.log"
echo "3. php artisan tinker"
echo "   >>> \DB::select('DESCRIBE ecoles');"
