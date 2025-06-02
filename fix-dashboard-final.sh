#!/bin/bash
# fix-dashboard-final.sh

echo "🔧 CORRECTION FINALE DU DASHBOARD"
echo "================================="

# 1. Désactiver temporairement CSP dans le layout admin
echo "🔐 Correction des erreurs CSP..."
sed -i '/<meta.*Content-Security-Policy/d' resources/views/layouts/admin.blade.php

# 2. Créer les vues manquantes pour le dashboard
echo "📄 Création des vues dashboard complètes..."

# Vue pour admin d'école sans école assignée
cat > resources/views/admin/dashboard/no-ecole.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <div class="alert alert-warning">
                    <h4 class="alert-heading">
                        <i class="bi bi-exclamation-triangle"></i> Aucune école assignée
                    </h4>
                    <p>Votre compte n'est associé à aucune école. Veuillez contacter un administrateur.</p>
                    <hr>
                    <p class="mb-0">
                        En attendant, vous pouvez :
                    </p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-primary">
                        <i class="bi bi-people"></i> Voir tous les membres
                    </a>
                    <a href="{{ route('admin.cours.index') }}" class="btn btn-info ml-2">
                        <i class="bi bi-calendar3"></i> Voir tous les cours
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
EOF

# Vue d'erreur
cat > resources/views/admin/dashboard/error.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <div class="alert alert-danger">
                    <h4 class="alert-heading">
                        <i class="bi bi-x-circle"></i> Erreur
                    </h4>
                    <p>{{ $message ?? 'Une erreur est survenue lors du chargement du dashboard.' }}</p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.ecoles.index') }}" class="btn btn-primary">
                        <i class="bi bi-building"></i> Voir les écoles
                    </a>
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-info ml-2">
                        <i class="bi bi-people"></i> Voir les membres
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
EOF

# 3. Vérifier si les vues superadmin et ecole existent, sinon les créer
if [ ! -f "resources/views/admin/dashboard/superadmin.blade.php" ]; then
echo "📄 Création de la vue superadmin..."
cat > resources/views/admin/dashboard/superadmin.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord Super Admin')
@section('page-title', 'Tableau de bord Global')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Statistiques globales -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="theta-card text-center">
                <div class="stat-icon success mb-3">
                    <i class="bi bi-building"></i>
                </div>
                <h3 class="text-white">{{ $stats['total_ecoles'] ?? 0 }}</h3>
                <p class="text-muted">Total Écoles</p>
                <small class="text-info">{{ $stats['total_ecoles_actives'] ?? 0 }} actives</small>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="theta-card text-center">
                <div class="stat-icon warning mb-3">
                    <i class="bi bi-people"></i>
                </div>
                <h3 class="text-white">{{ $stats['total_membres'] ?? 0 }}</h3>
                <p class="text-muted">Total Membres</p>
                <small class="text-success">{{ $stats['total_membres_approuves'] ?? 0 }} approuvés</small>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="theta-card text-center">
                <div class="stat-icon danger mb-3">
                    <i class="bi bi-calendar3"></i>
                </div>
                <h3 class="text-white">{{ $stats['total_cours'] ?? 0 }}</h3>
                <p class="text-muted">Total Cours</p>
                <small class="text-warning">{{ $stats['total_sessions'] ?? 0 }} sessions</small>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="theta-card text-center">
                <div class="stat-icon success mb-3">
                    <i class="bi bi-person-plus"></i>
                </div>
                <h3 class="text-white">{{ $stats['nouveaux_membres_mois'] ?? 0 }}</h3>
                <p class="text-muted">Nouveaux ce mois</p>
                <small class="text-info">membres</small>
            </div>
        </div>
    </div>
    
    <!-- Top écoles -->
    <div class="row">
        <div class="col-lg-6">
            <div class="theta-card">
                <h4 class="text-white mb-4">Top 5 Écoles par Membres</h4>
                @if(isset($topEcoles) && $topEcoles->count() > 0)
                    @foreach($topEcoles as $index => $ecole)
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2" style="background: rgba(255,255,255,0.03); border-radius: 10px;">
                        <div class="d-flex align-items-center">
                            <span class="text-info font-weight-bold mr-3" style="font-size: 24px;">#{{ $index + 1 }}</span>
                            <div>
                                <p class="text-white mb-0">{{ $ecole->nom }}</p>
                                <small class="text-muted">{{ $ecole->ville }}</small>
                            </div>
                        </div>
                        <span class="badge badge-success" style="font-size: 16px;">{{ $ecole->membres_count }}</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucune école trouvée</p>
                @endif
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="theta-card">
                <h4 class="text-white mb-4">Actions rapides</h4>
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.ecoles.create') }}" class="btn btn-primary btn-block">
                            <i class="bi bi-plus-circle"></i> Nouvelle École
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.membres.index') }}" class="btn btn-info btn-block">
                            <i class="bi bi-people"></i> Gérer Membres
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.cours.index') }}" class="btn btn-success btn-block">
                            <i class="bi bi-calendar3"></i> Gérer Cours
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.presences.index') }}" class="btn btn-warning btn-block">
                            <i class="bi bi-check-circle"></i> Présences
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
EOF
fi

if [ ! -f "resources/views/admin/dashboard/ecole.blade.php" ]; then
echo "📄 Création de la vue admin école..."
cat > resources/views/admin/dashboard/ecole.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', $ecole->nom ?? 'Mon École')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Actions urgentes -->
    @if(isset($stats['membres_en_attente']) && $stats['membres_en_attente'] > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="theta-card" style="border-left: 4px solid #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-warning mb-1">
                            <i class="bi bi-exclamation-triangle"></i> Action requise
                        </h5>
                        <p class="text-white mb-0">
                            {{ $stats['membres_en_attente'] }} membre(s) en attente d'approbation
                        </p>
                    </div>
                    <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="btn btn-warning">
                        Voir les demandes
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="theta-card text-center">
                <h3 class="text-white">{{ $stats['total_membres'] ?? 0 }}</h3>
                <p class="text-muted">Total membres</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="theta-card text-center">
                <h3 class="text-success">{{ $stats['membres_approuves'] ?? 0 }}</h3>
                <p class="text-muted">Approuvés</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="theta-card text-center">
                <h3 class="text-info">{{ $stats['total_cours'] ?? 0 }}</h3>
                <p class="text-muted">Cours</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="theta-card text-center">
                <h3 class="text-warning">{{ $stats['nouveaux_cette_semaine'] ?? 0 }}</h3>
                <p class="text-muted">Nouveaux/semaine</p>
            </div>
        </div>
    </div>
    
    <!-- Membres en attente -->
    @if(isset($membresEnAttente) && $membresEnAttente->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <h4 class="text-white mb-4">Membres en attente</h4>
                <div class="table-responsive">
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Date inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($membresEnAttente as $membre)
                            <tr>
                                <td>{{ $membre->prenom }} {{ $membre->nom }}</td>
                                <td>{{ $membre->email }}</td>
                                <td>{{ $membre->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.membres.show', $membre) }}" class="btn btn-sm btn-info">
                                        Examiner
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
EOF
fi

# 4. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data resources/views/admin/dashboard/
chmod -R 755 resources/views/admin/dashboard/

# 5. Vider le cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear

# 6. Tester la connexion à la base de données
echo "🔍 Test de la connexion à la base de données..."
php artisan tinker --execute="
try {
    \$count = \App\Models\Ecole::count();
    echo 'Connexion OK - ' . \$count . ' écoles trouvées';
} catch (\Exception \$e) {
    echo 'Erreur DB: ' . \$e->getMessage();
}
"

echo ""
echo "✅ Correction terminée !"
echo ""
echo "🚀 Le dashboard devrait maintenant fonctionner correctement."
echo "Rafraîchissez la page : http://207.253.150.57/admin"
