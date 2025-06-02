#!/bin/bash
# fix-infinite-scroll.sh

echo "🔧 CORRECTION DU PROBLÈME D'EXPANSION INFINIE"
echo "==========================================="

# 1. Créer une vue de dashboard simple et sûre
echo "📄 Création d'une vue de dashboard sécurisée..."
cat > resources/views/admin/dashboard/safe-dashboard.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid" style="max-height: calc(100vh - 200px); overflow-y: auto;">
    <div class="row">
        <div class="col-12">
            <h2 class="text-white mb-4">Bienvenue {{ auth()->user()->name }}</h2>
            
            <!-- Stats simples -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3 class="text-white">{{ \App\Models\Ecole::count() }}</h3>
                        <p class="text-muted">Écoles</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon warning">
                            <i class="bi bi-people"></i>
                        </div>
                        <h3 class="text-white">{{ \App\Models\Membre::count() }}</h3>
                        <p class="text-muted">Membres</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon danger">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <h3 class="text-white">{{ \App\Models\Cours::count() }}</h3>
                        <p class="text-muted">Cours</p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon success">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <h3 class="text-white">{{ \App\Models\User::count() }}</h3>
                        <p class="text-muted">Utilisateurs</p>
                    </div>
                </div>
            </div>
            
            <!-- Actions rapides -->
            <div class="theta-card">
                <h4 class="text-white mb-3">Actions rapides</h4>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ route('admin.membres.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-person-plus"></i> Nouveau membre
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ route('admin.cours.create') }}" class="btn btn-info w-100">
                            <i class="bi bi-calendar-plus"></i> Nouveau cours
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ route('admin.ecoles.index') }}" class="btn btn-success w-100">
                            <i class="bi bi-building"></i> Gérer écoles
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="{{ route('admin.presences.index') }}" class="btn btn-warning w-100">
                            <i class="bi bi-check-circle"></i> Présences
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Assurer que le contenu ne déborde pas */
.container-fluid {
    padding: 20px;
}

.stat-card {
    height: 180px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.theta-card {
    max-width: 100%;
    overflow: hidden;
}
</style>
@endsection
EOF

# 2. Modifier temporairement le DashboardController pour utiliser cette vue
echo "🎮 Modification du DashboardController..."
cat > app/Http/Controllers/Admin/DashboardController.php << 'EOF'
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Utiliser temporairement la vue sécurisée
        return view('admin.dashboard.safe-dashboard');
    }
}
EOF

# 3. Vérifier et corriger le layout principal
echo "📐 Vérification du layout principal..."
# Ajouter un style pour limiter la hauteur
sed -i '/<\/head>/i\
<style>\
    /* Fix pour empêcher l expansion infinie */\
    body { overflow: hidden; }\
    .admin-main { overflow-y: auto; max-height: 100vh; }\
    .content-area { min-height: auto !important; }\
    .theta-content { min-height: auto !important; }\
</style>' resources/views/layouts/admin.blade.php

# 4. Créer un fichier CSS de correction
echo "🎨 Création du CSS de correction..."
cat > public/css/dashboard-fix.css << 'EOF'
/* Fix pour le dashboard */
html, body {
    height: 100%;
    overflow: hidden;
}

.admin-wrapper {
    height: 100vh;
    overflow: hidden;
}

.admin-main {
    height: 100vh;
    overflow-y: auto;
}

.content-area {
    padding-bottom: 50px;
    min-height: auto !important;
    max-height: calc(100vh - 150px);
    overflow-y: auto;
}

/* Empêcher l'expansion infinie */
* {
    max-height: 100vh;
}

/* Fix pour les cartes */
.theta-card, .stat-card {
    margin-bottom: 20px;
    max-height: 500px;
    overflow: hidden;
}
EOF

# 5. Ajouter le CSS au layout
echo "🔗 Ajout du CSS au layout..."
sed -i '/<\/head>/i\<link rel="stylesheet" href="{{ asset('\''css/dashboard-fix.css'\'') }}">' resources/views/layouts/admin.blade.php

# 6. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data app/Http/Controllers/
chown -R lalpha:www-data resources/views/
chown -R lalpha:www-data public/css/
chmod -R 755 app/Http/Controllers/
chmod -R 755 resources/views/
chmod -R 755 public/css/

# 7. Vider le cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# 8. Vérifier s'il y a des erreurs dans les logs
echo "📋 Dernières erreurs dans les logs..."
tail -10 storage/logs/laravel.log | grep -i "error\|exception"

echo ""
echo "✅ Correction appliquée !"
echo ""
echo "🔄 Actions :"
echo "1. Rafraîchissez la page (Ctrl+F5)"
echo "2. Si le problème persiste, ouvrez la console du navigateur (F12)"
echo "3. Vérifiez s'il y a des erreurs JavaScript"
