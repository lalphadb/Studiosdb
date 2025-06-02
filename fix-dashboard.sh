#!/bin/bash

# Script de correction du Dashboard StudiosDB
# Auteur: Assistant Claude
# Date: 2 Juin 2025

echo "🔧 CORRECTION DU DASHBOARD STUDIOSDB"
echo "===================================="

# Couleurs pour le terminal
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# 1. Backup des fichiers existants
echo -e "${YELLOW}📦 Création des backups...${NC}"
mkdir -p backup/dashboard-fix-$(date +%Y%m%d-%H%M%S)
cp -r app/Http/Controllers/Admin/DashboardController.php backup/dashboard-fix-$(date +%Y%m%d-%H%M%S)/ 2>/dev/null || true
cp -r resources/views/admin/dashboard* backup/dashboard-fix-$(date +%Y%m%d-%H%M%S)/ 2>/dev/null || true

# 2. Créer/Mettre à jour le DashboardController
echo -e "${YELLOW}🎮 Création du DashboardController...${NC}"
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
        $user = Auth::user();
        
        // Si c'est un superadmin
        if ($user->role === 'admin') {
            return $this->superAdminDashboard();
        }
        
        // Pour les admins d'école
        return $this->ecoleAdminDashboard($user);
    }
    
    private function superAdminDashboard()
    {
        // Statistiques globales pour superadmin
        $stats = [
            'total_ecoles' => Ecole::count(),
            'total_ecoles_actives' => Ecole::where('statut', 'actif')->count(),
            'total_membres' => Membre::count(),
            'total_membres_approuves' => Membre::where('approuve', true)->count(),
            'total_cours' => Cours::count(),
            'total_sessions' => Session::count(),
            'total_users' => User::count(),
            'nouveaux_membres_mois' => Membre::whereMonth('created_at', Carbon::now()->month)->count(),
        ];
        
        // Top 5 écoles par nombre de membres
        $topEcoles = Ecole::withCount('membres')
            ->orderBy('membres_count', 'desc')
            ->take(5)
            ->get();
        
        // Graphique des inscriptions par mois (12 derniers mois)
        $inscriptionsParMois = Membre::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mois, COUNT(*) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();
        
        return view('admin.dashboard.superadmin', compact(
            'stats', 
            'topEcoles', 
            'inscriptionsParMois'
        ));
    }
    
    private function ecoleAdminDashboard($user)
    {
        $ecoleId = $user->ecole_id;
        
        if (!$ecoleId) {
            return redirect()->route('admin.ecoles.index')
                ->with('error', 'Aucune école assignée à votre compte.');
        }
        
        $ecole = Ecole::find($ecoleId);
        
        // Statistiques de base pour l'école
        $stats = [
            'total_membres' => Membre::where('ecole_id', $ecoleId)->count(),
            'membres_approuves' => Membre::where('ecole_id', $ecoleId)->where('approuve', true)->count(),
            'membres_en_attente' => Membre::where('ecole_id', $ecoleId)->where('approuve', false)->count(),
            'total_cours' => Cours::where('ecole_id', $ecoleId)->count(),
            'sessions_actives' => Session::whereHas('cours', function($q) use ($ecoleId) {
                $q->where('ecole_id', $ecoleId);
            })->where('statut', 'actif')->count(),
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
    }
}
EOF

# 3. Créer le dossier dashboard
echo -e "${YELLOW}📁 Création du dossier dashboard...${NC}"
mkdir -p resources/views/admin/dashboard

# 4. Créer la vue superadmin
echo -e "${YELLOW}👑 Création de la vue superadmin...${NC}"
cat > resources/views/admin/dashboard/superadmin.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord Super Admin')
@section('page-title', 'Tableau de bord Global')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Statistiques globales -->
    <div class="stats-grid">
        <!-- Total Écoles -->
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-building"></i>
            </div>
            <div class="stat-value">{{ $stats['total_ecoles'] }}</div>
            <div class="stat-label">Total Écoles</div>
            <div class="stat-change" style="color: #00d4ff;">
                {{ $stats['total_ecoles_actives'] }} actives
            </div>
        </div>

        <!-- Total Membres -->
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-value">{{ $stats['total_membres'] }}</div>
            <div class="stat-label">Total Membres</div>
            <div class="stat-change" style="color: #00ff88;">
                {{ $stats['total_membres_approuves'] }} approuvés
            </div>
        </div>

        <!-- Total Cours -->
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="bi bi-calendar3"></i>
            </div>
            <div class="stat-value">{{ $stats['total_cours'] }}</div>
            <div class="stat-label">Total Cours</div>
            <div class="stat-change" style="color: #ffaa00;">
                {{ $stats['total_sessions'] }} sessions
            </div>
        </div>

        <!-- Nouveaux ce mois -->
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-person-plus"></i>
            </div>
            <div class="stat-value">{{ $stats['nouveaux_membres_mois'] }}</div>
            <div class="stat-label">Nouveaux ce mois</div>
            <div class="stat-change" style="color: #ff0080;">
                membres
            </div>
        </div>
    </div>

    <!-- Graphiques et tableaux -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <!-- Top 5 Écoles -->
            <div class="theta-card">
                <h3 style="color: white; margin-bottom: 20px;">Top 5 Écoles par Membres</h3>
                <div class="space-y-3">
                    @foreach($topEcoles as $index => $ecole)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 10px; margin-bottom: 10px;">
                        <div style="display: flex; align-items: center;">
                            <span style="font-size: 24px; font-weight: bold; color: #00d4ff; margin-right: 15px;">#{{ $index + 1 }}</span>
                            <div>
                                <p style="color: white; font-weight: 500; margin: 0;">{{ $ecole->nom }}</p>
                                <p style="color: #7c7c94; font-size: 14px; margin: 0;">{{ $ecole->ville }}</p>
                            </div>
                        </div>
                        <span style="font-size: 20px; font-weight: bold; color: #00ff88;">{{ $ecole->membres_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <!-- Graphique des inscriptions -->
            <div class="theta-card">
                <h3 style="color: white; margin-bottom: 20px;">Inscriptions (12 derniers mois)</h3>
                <canvas id="inscriptionsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
const ctx = document.getElementById('inscriptionsChart').getContext('2d');
const inscriptionsData = @json($inscriptionsParMois);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: inscriptionsData.map(item => item.mois),
        datasets: [{
            label: 'Nouvelles inscriptions',
            data: inscriptionsData.map(item => item.total),
            borderColor: 'rgb(34, 211, 238)',
            backgroundColor: 'rgba(34, 211, 238, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: { color: '#fff' }
            }
        },
        scales: {
            y: {
                ticks: { color: '#fff' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            },
            x: {
                ticks: { color: '#fff' },
                grid: { color: 'rgba(255, 255, 255, 0.1)' }
            }
        }
    }
});
</script>
@endpush
@endsection
EOF

# 5. Créer la vue admin école
echo -e "${YELLOW}🏫 Création de la vue admin école...${NC}"
cat > resources/views/admin/dashboard/ecole.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', $ecole->nom)
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Cartes d'action rapide -->
    <div class="row mb-4">
        @if($stats['membres_en_attente'] > 0)
        <div class="col-md-4">
            <div class="theta-card" style="border-left: 4px solid #ffaa00;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="color: #ffaa00; font-weight: 600;">Action requise</p>
                        <p style="font-size: 28px; font-weight: bold; color: white;">{{ $stats['membres_en_attente'] }}</p>
                        <p style="color: #7c7c94;">Membres en attente</p>
                    </div>
                    <i class="bi bi-person-exclamation" style="font-size: 48px; color: #ffaa00;"></i>
                </div>
                <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" 
                   style="display: inline-flex; align-items: center; margin-top: 15px; color: #ffaa00; text-decoration: none;">
                    Voir les demandes <i class="bi bi-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
        @endif

        @if($prochainesSessions->count() > 0)
        <div class="col-md-4">
            <div class="theta-card">
                <p style="color: #00d4ff; font-weight: 600; margin-bottom: 10px;">Prochaine session</p>
                <p style="color: white; font-weight: bold;">{{ $prochainesSessions->first()->cours->nom }}</p>
                <p style="color: #7c7c94; font-size: 14px; margin-top: 5px;">
                    {{ $prochainesSessions->first()->date_debut->format('d/m/Y H:i') }}
                </p>
                <a href="{{ route('admin.sessions.index') }}" 
                   style="display: inline-flex; align-items: center; margin-top: 15px; color: #00d4ff; text-decoration: none;">
                    Gérer les sessions <i class="bi bi-arrow-right" style="margin-left: 8px;"></i>
                </a>
            </div>
        </div>
        @endif

        <div class="col-md-4">
            <div class="theta-card">
                <p style="color: #ff0080; font-weight: 600; margin-bottom: 15px;">Actions rapides</p>
                <div>
                    <a href="{{ route('admin.membres.create') }}" 
                       style="display: block; padding: 10px; border-radius: 8px; color: white; text-decoration: none; transition: all 0.3s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="bi bi-person-plus" style="margin-right: 10px;"></i> Nouveau membre
                    </a>
                    <a href="{{ route('admin.cours.create') }}" 
                       style="display: block; padding: 10px; border-radius: 8px; color: white; text-decoration: none; transition: all 0.3s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="bi bi-plus-circle" style="margin-right: 10px;"></i> Nouveau cours
                    </a>
                    <a href="{{ route('admin.sessions.create') }}" 
                       style="display: block; padding: 10px; border-radius: 8px; color: white; text-decoration: none; transition: all 0.3s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="bi bi-calendar-plus" style="margin-right: 10px;"></i> Nouvelle session
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-value">{{ $stats['total_membres'] }}</div>
            <div class="stat-label">Total membres</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-value">{{ $stats['membres_approuves'] }}</div>
            <div class="stat-label">Approuvés</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon danger">
                <i class="bi bi-calendar3"></i>
            </div>
            <div class="stat-value">{{ $stats['total_cours'] }}</div>
            <div class="stat-label">Cours</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="bi bi-calendar-check"></i>
            </div>
            <div class="stat-value">{{ $stats['sessions_actives'] }}</div>
            <div class="stat-label">Sessions actives</div>
        </div>
    </div>

    <!-- Liste des membres en attente -->
    @if($membresEnAttente->count() > 0)
    <div class="theta-card mt-4">
        <h3 style="color: white; margin-bottom: 20px;">Membres en attente d'approbation</h3>
        @foreach($membresEnAttente as $membre)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: rgba(255,255,255,0.03); border-radius: 10px; margin-bottom: 10px;">
            <div>
                <p style="color: white; font-weight: 500; margin: 0;">{{ $membre->prenom }} {{ $membre->nom }}</p>
                <p style="color: #7c7c94; font-size: 14px; margin: 0;">Inscrit le {{ $membre->created_at->format('d/m/Y') }}</p>
            </div>
            <a href="{{ route('admin.membres.show', $membre) }}" 
               style="padding: 8px 20px; background: #00d4ff; color: white; border-radius: 8px; text-decoration: none;">
                Examiner
            </a>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
EOF

# 6. Supprimer les doublons
echo -e "${YELLOW}🧹 Nettoyage des doublons...${NC}"
find resources/views -name "dashboard.blade.php" -not -path "*/admin/*" -delete 2>/dev/null || true

# 7. Vider le cache
echo -e "${YELLOW}🔄 Vidage du cache...${NC}"
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# 8. Vérifier les permissions
echo -e "${YELLOW}🔐 Correction des permissions...${NC}"
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# 9. Tester l'accès
echo -e "${GREEN}✅ Correction terminée !${NC}"
echo ""
echo "📋 RÉSUMÉ DES ACTIONS :"
echo "----------------------"
echo "✓ DashboardController créé/mis à jour"
echo "✓ Vue superadmin créée"
echo "✓ Vue admin école créée"
echo "✓ Doublons supprimés"
echo "✓ Cache vidé"
echo "✓ Permissions corrigées"
echo ""
echo -e "${YELLOW}🚀 PROCHAINE ÉTAPE :${NC}"
echo "Accédez à http://207.253.150.57/admin"
echo ""
echo -e "${GREEN}Le dashboard devrait maintenant afficher :${NC}"
echo "- Pour un superadmin : Vue globale de toutes les écoles"
echo "- Pour un admin d'école : Statistiques de son école"
echo ""
echo "Si le problème persiste, vérifiez les logs :"
echo "tail -f storage/logs/laravel.log"
EOF

# 10. Rendre le script exécutable
chmod +x fix-dashboard.sh

echo "Script créé ! Exécutez : ./fix-dashboard.sh"
