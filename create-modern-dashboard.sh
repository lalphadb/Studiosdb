#!/bin/bash
# create-modern-dashboard.sh

echo "🎨 CRÉATION DU NOUVEAU DASHBOARD MODERNE"
echo "======================================="

# 1. Créer le nouveau layout moderne
echo "📐 Création du nouveau layout..."
cat > resources/views/layouts/modern-admin.blade.php << 'EOF'
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Studios Unis') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --bg-primary: #0f1419;
            --bg-secondary: #1a1f26;
            --bg-card: #1e2329;
            --text-primary: #ffffff;
            --text-secondary: #8b92a3;
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --accent-orange: #f59e0b;
            --accent-red: #ef4444;
            --accent-purple: #8b5cf6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
        }
        
        /* Top Navigation */
        .top-nav {
            background: var(--bg-secondary);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        /* Main Container */
        .dashboard-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .dashboard-header {
            margin-bottom: 2rem;
        }
        
        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .dashboard-subtitle {
            color: var(--text-secondary);
        }
        
        .date-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 1rem;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        
        .stat-card.blue::before { background: var(--accent-blue); }
        .stat-card.green::before { background: var(--accent-green); }
        .stat-card.orange::before { background: var(--accent-orange); }
        .stat-card.red::before { background: var(--accent-red); }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
        }
        
        .stat-icon.blue { background: rgba(59, 130, 246, 0.2); color: var(--accent-blue); }
        .stat-icon.green { background: rgba(16, 185, 129, 0.2); color: var(--accent-green); }
        .stat-icon.orange { background: rgba(245, 158, 11, 0.2); color: var(--accent-orange); }
        .stat-icon.red { background: rgba(239, 68, 68, 0.2); color: var(--accent-red); }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            margin-top: 1rem;
        }
        
        .stat-link:hover {
            color: var(--text-primary);
        }
        
        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .content-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1.5rem;
        }
        
        .content-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .content-title {
            font-size: 1.125rem;
            font-weight: 600;
        }
        
        /* Table Styles */
        .modern-table {
            width: 100%;
        }
        
        .modern-table th {
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-secondary);
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .modern-table td {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .member-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .member-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .member-name {
            font-weight: 500;
        }
        
        .member-date {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge.active {
            background: rgba(16, 185, 129, 0.2);
            color: var(--accent-green);
        }
        
        .badge.pending {
            background: rgba(245, 158, 11, 0.2);
            color: var(--accent-orange);
        }
        
        /* Actions */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .btn-icon:hover {
            background: rgba(255,255,255,0.2);
            color: var(--text-primary);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }
        
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="logo">
            <span>Studios Unis</span>
        </div>
        
        <div class="user-info">
            <button class="btn-icon">
                <i class="fa fa-bell"></i>
            </button>
            <div class="user-avatar">
                {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
            </div>
            <span>{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="dashboard-container">
        @yield('content')
    </main>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
EOF

# 2. Créer la nouvelle vue du dashboard
echo "📄 Création de la vue dashboard moderne..."
cat > resources/views/admin/dashboard/modern.blade.php << 'EOF'
@extends('layouts.modern-admin')

@section('title', 'Tableau de bord')

@section('content')
<!-- Header -->
<div class="dashboard-header">
    <h1 class="dashboard-title">
        <i class="fa fa-chart-line" style="margin-right: 0.5rem;"></i>
        Tableau de bord
    </h1>
    <p class="dashboard-subtitle">Vue d'ensemble de votre système de gestion - Studios Unis</p>
    <div class="date-info">
        <i class="fa fa-calendar"></i>
        <span>{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</span>
        <span style="margin-left: 1rem;">
            <i class="fa fa-clock"></i>
            Dernière mise à jour: {{ now()->format('H:i') }}
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <!-- Membres inscrits -->
    <div class="stat-card blue">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_membres'] ?? 11 }}</div>
                <div class="stat-label">Membres inscrits</div>
            </div>
            <div class="stat-icon blue">
                <i class="fa fa-users"></i>
            </div>
        </div>
        <a href="{{ route('admin.membres.index') }}" class="stat-link">
            Voir tous les membres <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Présences -->
    <div class="stat-card green">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['presences_jour'] ?? 0 }}</div>
                <div class="stat-label">Présences aujourd'hui</div>
            </div>
            <div class="stat-icon green">
                <i class="fa fa-check-circle"></i>
            </div>
        </div>
        <a href="{{ route('admin.presences.index') }}" class="stat-link">
            Gérer les présences <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Membres en attente -->
    <div class="stat-card orange">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['membres_en_attente'] ?? 0 }}</div>
                <div class="stat-label">Membres en attente</div>
            </div>
            <div class="stat-icon orange">
                <i class="fa fa-user-clock"></i>
            </div>
        </div>
        <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" class="stat-link">
            Voir les demandes <i class="fa fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Écoles actives -->
    <div class="stat-card red">
        <div class="stat-header">
            <div>
                <div class="stat-value">{{ $stats['total_ecoles'] ?? 22 }}</div>
                <div class="stat-label">École(s) active(s)</div>
            </div>
            <div class="stat-icon red">
                <i class="fa fa-school"></i>
            </div>
        </div>
        <a href="{{ route('admin.ecoles.index') }}" class="stat-link">
            Gérer les écoles <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Content Grid -->
<div class="content-grid">
    <!-- Derniers membres -->
    <div class="content-card">
        <div class="content-header">
            <i class="fa fa-user-plus" style="color: var(--accent-blue);"></i>
            <h2 class="content-title">Derniers membres inscrits</h2>
        </div>
        
        @if(isset($derniers_membres) && $derniers_membres->count() > 0)
        <table class="modern-table">
            <thead>
                <tr>
                    <th>MEMBRE</th>
                    <th>CONTACT</th>
                    <th>ÉCOLE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($derniers_membres as $membre)
                <tr>
                    <td>
                        <div class="member-info">
                            <div class="member-avatar">
                                {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                            </div>
                            <div>
                                <div class="member-name">{{ $membre->prenom }} {{ $membre->nom }}</div>
                                <div class="member-date">Inscrit le {{ $membre->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $membre->email ?? 'test@test.com' }}</div>
                        <div class="member-date">{{ $membre->telephone ?? '418-555-0123' }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $membre->approuve ? 'active' : 'pending' }}">
                            {{ $membre->ecole->nom ?? 'École' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.membres.show', $membre) }}" class="btn-icon" title="Voir">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.membres.edit', $membre) }}" class="btn-icon" title="Modifier">
                                <i class="fa fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-users"></i></div>
            <p>Aucun membre inscrit récemment</p>
        </div>
        @endif
    </div>
    
    <!-- Sessions récentes -->
    <div class="content-card">
        <div class="content-header">
            <i class="fa fa-calendar-check" style="color: var(--accent-green);"></i>
            <h2 class="content-title">Sessions de cours récentes</h2>
        </div>
        
        @if(isset($sessions_recentes) && $sessions_recentes->count() > 0)
        <table class="modern-table">
            <thead>
                <tr>
                    <th>SESSION</th>
                    <th>PARTICIPANTS</th>
                    <th>STATUT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions_recentes as $session)
                <tr>
                    <td>
                        <div>
                            <div class="member-name">{{ $session->cours->nom ?? 'Session' }}</div>
                            <div class="member-date">{{ $session->date_debut->format('d/m/Y H:i') }}</div>
                        </div>
                    </td>
                    <td>{{ $session->inscriptions_count ?? 0 }}/{{ $session->places_max ?? 30 }}</td>
                    <td>
                        <span class="badge active">Actif</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fa fa-calendar"></i></div>
            <p>Aucune session de cours récente trouvée</p>
        </div>
        @endif
    </div>
</div>
@endsection
EOF

# 3. Mettre à jour le DashboardController
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
use App\Models\Presence;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques générales
        $stats = [
            'total_membres' => Membre::count(),
            'membres_en_attente' => Membre::where('approuve', false)->count(),
            'total_ecoles' => Ecole::count(),
            'presences_jour' => Presence::whereDate('created_at', Carbon::today())->count(),
        ];
        
        // Derniers membres inscrits
        $derniers_membres = Membre::with('ecole')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Sessions récentes
        $sessions_recentes = CoursSession::with('cours')
            ->withCount('inscriptions')
            ->orderBy('date_debut', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard.modern', compact(
            'stats',
            'derniers_membres',
            'sessions_recentes'
        ));
    }
}
EOF

# 4. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data resources/views/
chown -R lalpha:www-data app/Http/Controllers/
chmod -R 755 resources/views/
chmod -R 755 app/Http/Controllers/

# 5. Vider le cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Dashboard moderne créé avec succès !"
echo ""
echo "🎨 Caractéristiques du nouveau design :"
echo "- Interface sombre et moderne"
echo "- Cartes colorées avec indicateurs visuels"
echo "- Tableaux élégants avec avatars"
echo "- Badges colorés pour les statuts"
echo "- Navigation horizontale épurée"
echo "- Icônes Font Awesome intégrées"
echo ""
echo "🔄 Rafraîchissez la page pour voir le nouveau design !"
