#!/bin/bash
# improve-ecole-dashboard.sh

echo "🏫 AMÉLIORATION DU DASHBOARD ADMIN ÉCOLE"
echo "========================================"

# 1. Sauvegarder l'original
echo "💾 Sauvegarde du fichier original..."
cp resources/views/admin/dashboard/ecole.blade.php resources/views/admin/dashboard/ecole.blade.php.bak

# 2. Recréer la vue avec le même style que superadmin
echo "📝 Mise à jour complète du dashboard école..."
cat > resources/views/admin/dashboard/ecole.blade.php << 'EOF'
@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', $ecole->nom)
@section('breadcrumb', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- En-tête école -->
    <div class="dashboard-header" style="background: rgba(255,255,255,0.02); backdrop-filter: blur(10px); border-radius: 20px; padding: 2rem; margin-bottom: 2rem;">
        <h1 class="dashboard-title" style="font-size: 2.5rem; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,.3);">
            <i class="fas fa-school"></i> {{ $ecole->nom }}
        </h1>
        <p style="color: #8b92a3;">{{ $ecole->ville }}, {{ $ecole->province }} • Tableau de bord administratif</p>
    </div>

    <!-- Alerte membres en attente -->
    @if($stats['membres_en_attente'] > 0)
    <div style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.3); border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; backdrop-filter: blur(10px);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-exclamation-triangle" style="color: #f59e0b; font-size: 1.5rem; animation: pulse 2s infinite;"></i>
            <div>
                <p style="font-weight: 600; margin: 0; color: #ffffff;">Action requise</p>
                <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">{{ $stats['membres_en_attente'] }} membre(s) en attente d'approbation</p>
            </div>
        </div>
        <a href="{{ route('admin.membres.index', ['approuve' => '0']) }}" 
           style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(245,158,11,0.3);"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(245,158,11,0.4)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(245,158,11,0.3)'">
            Examiner maintenant
        </a>
    </div>
    @endif

    <!-- Grille de statistiques -->
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Membres actifs -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #10b981, #3b82f6);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #3b82f6); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(16,185,129,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['membres_actifs'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Membres actifs</p>
                <p style="color: #10b981; font-size: 0.875rem; margin-top: 0.5rem;">
                    @if($stats['total_membres'] > 0)
                        {{ round(($stats['membres_actifs'] / $stats['total_membres']) * 100) }}% approuvés
                    @else
                        Aucun membre
                    @endif
                </p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.membres.index') }}" style="color: #10b981; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Gérer les membres <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Présences aujourd'hui -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #3b82f6, #8b5cf6);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(59,130,246,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['presences_jour'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Présences aujourd'hui</p>
                <p style="color: #3b82f6; font-size: 0.875rem; margin-top: 0.5rem;">{{ now()->format('d/m/Y') }}</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.presences.create') }}" style="color: #3b82f6; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Prendre les présences <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Cours actifs -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #8b5cf6, #ec4899);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(139,92,246,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['cours_actifs'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Cours actifs</p>
                <p style="color: #ec4899; font-size: 0.875rem; margin-top: 0.5rem;">Dans votre école</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.cours.index') }}" style="color: #8b5cf6; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Gérer les cours <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Sessions cette semaine -->
        <div class="stat-card-modern" 
             style="background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; position: relative; overflow: hidden; transition: all 0.3s ease; cursor: pointer;"
             onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3), 0 0 30px rgba(255,255,255,0.1)'"
             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
            <div style="position: absolute; top: 0; left: 0; right: 0; height: 4px; background: linear-gradient(90deg, #f59e0b, #ef4444);"></div>
            <div class="stat-card-content">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: white; width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 28px; box-shadow: 0 8px 32px rgba(245,158,11,0.3); margin-bottom: 1rem; transition: transform 0.3s ease;">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <h3 class="stat-value" style="font-size: 2.5rem; font-weight: 700; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">{{ $stats['sessions_semaine'] }}</h3>
                <p class="stat-label" style="color: #8b92a3; margin: 0;">Sessions cette semaine</p>
                <p style="color: #f59e0b; font-size: 0.875rem; margin-top: 0.5rem;">À venir</p>
            </div>
            <div class="stat-footer" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="{{ route('admin.sessions.index') }}" style="color: #f59e0b; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: color 0.3s;">
                    Voir le calendrier <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; margin-bottom: 2rem; transition: all 0.3s ease;">
        <div class="content-card-header" style="margin-bottom: 1.5rem;">
            <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                <i class="fas fa-bolt" style="color: #f59e0b;"></i> Actions Rapides
            </h3>
        </div>
        <div class="quick-actions" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="{{ route('admin.membres.create') }}" class="action-btn" 
               style="background: linear-gradient(135deg, rgba(16,185,129,0.1), rgba(59,130,246,0.1)); border: 1px solid rgba(16,185,129,0.3); color: #10b981; padding: 1.5rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.75rem;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(16,185,129,0.3)'; this.style.background='linear-gradient(135deg, rgba(16,185,129,0.2), rgba(59,130,246,0.2))'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='linear-gradient(135deg, rgba(16,185,129,0.1), rgba(59,130,246,0.1))'">
                <i class="fas fa-user-plus" style="font-size: 2rem;"></i>
                <span style="font-weight: 500;">Nouveau membre</span>
            </a>
            
            <a href="{{ route('admin.presences.create') }}" class="action-btn" 
               style="background: linear-gradient(135deg, rgba(59,130,246,0.1), rgba(139,92,246,0.1)); border: 1px solid rgba(59,130,246,0.3); color: #3b82f6; padding: 1.5rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.75rem;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(59,130,246,0.3)'; this.style.background='linear-gradient(135deg, rgba(59,130,246,0.2), rgba(139,92,246,0.2))'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='linear-gradient(135deg, rgba(59,130,246,0.1), rgba(139,92,246,0.1))'">
                <i class="fas fa-check-circle" style="font-size: 2rem;"></i>
                <span style="font-weight: 500;">Prendre présences</span>
            </a>
            
            <a href="{{ route('admin.cours.create') }}" class="action-btn" 
               style="background: linear-gradient(135deg, rgba(139,92,246,0.1), rgba(236,72,153,0.1)); border: 1px solid rgba(139,92,246,0.3); color: #8b5cf6; padding: 1.5rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.75rem;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(139,92,246,0.3)'; this.style.background='linear-gradient(135deg, rgba(139,92,246,0.2), rgba(236,72,153,0.2))'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='linear-gradient(135deg, rgba(139,92,246,0.1), rgba(236,72,153,0.1))'">
                <i class="fas fa-calendar-plus" style="font-size: 2rem;"></i>
                <span style="font-weight: 500;">Créer un cours</span>
            </a>
            
            <a href="{{ route('admin.inscriptions.create') }}" class="action-btn" 
               style="background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(239,68,68,0.1)); border: 1px solid rgba(245,158,11,0.3); color: #f59e0b; padding: 1.5rem; border-radius: 12px; text-align: center; text-decoration: none; transition: all 0.3s ease; display: flex; flex-direction: column; align-items: center; gap: 0.75rem;"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 20px rgba(245,158,11,0.3)'; this.style.background='linear-gradient(135deg, rgba(245,158,11,0.2), rgba(239,68,68,0.2))'"
               onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'; this.style.background='linear-gradient(135deg, rgba(245,158,11,0.1), rgba(239,68,68,0.1))'">
                <i class="fas fa-clipboard-list" style="font-size: 2rem;"></i>
                <span style="font-weight: 500;">Nouvelle inscription</span>
            </a>
        </div>
    </div>

    <!-- Contenu en 2 colonnes -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <!-- Sessions aujourd'hui -->
        <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; transition: all 0.3s ease;">
            <div class="content-card-header" style="margin-bottom: 1.5rem;">
                <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    <i class="fas fa-calendar-day" style="color: #3b82f6;"></i> Sessions aujourd'hui
                </h3>
            </div>
            <div class="content-card-body">
                @forelse($sessionsAujourdhui ?? [] as $session)
                <div style="padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 12px; margin-bottom: 0.75rem; transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.transform='translateX(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <p style="font-weight: 600; margin: 0; color: #ffffff;">{{ $session->cours->nom }}</p>
                            <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">
                                <i class="fas fa-clock" style="margin-right: 5px;"></i>
                                {{ $session->date_debut->format('H:i') }} - {{ $session->date_fin->format('H:i') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.presences.create', ['session_id' => $session->id]) }}" 
                           style="background: linear-gradient(135deg, #3b82f6, #8b5cf6); color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 15px rgba(59,130,246,0.4)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                            Présences
                        </a>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem;">
                    <i class="fas fa-calendar-times" style="font-size: 3rem; color: #8b92a3; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                    <p style="color: #8b92a3;">Aucune session programmée aujourd'hui</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Membres en attente -->
        <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; transition: all 0.3s ease;">
            <div class="content-card-header" style="margin-bottom: 1.5rem;">
                <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    <i class="fas fa-user-clock" style="color: #f59e0b;"></i> Membres en attente
                </h3>
            </div>
            <div class="content-card-body">
                @forelse($membresEnAttente as $membre)
                <div style="padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 12px; margin-bottom: 0.75rem; transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.transform='translateX(5px)'"
                     onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.transform='translateX(0)'">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f59e0b, #ef4444); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px;">
                                {{ substr($membre->prenom, 0, 1) . substr($membre->nom, 0, 1) }}
                            </div>
                            <div>
                                <p style="font-weight: 600; margin: 0; color: #ffffff;">{{ $membre->prenom }} {{ $membre->nom }}</p>
                                <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">
                                    <i class="fas fa-calendar" style="margin-right: 5px;"></i>
                                    {{ $membre->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('admin.membres.show', $membre) }}" 
                           style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.875rem; transition: all 0.3s ease;"
                           onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 15px rgba(245,158,11,0.4)'"
                           onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none'">
                            Examiner
                        </a>
                    </div>
                </div>
                @empty
                <div style="text-align: center; padding: 3rem;">
                    <i class="fas fa-user-check" style="font-size: 3rem; color: #8b92a3; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                    <p style="color: #8b92a3;">Aucun membre en attente</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Prochains cours -->
    <div class="content-card" style="background: rgba(255,255,255,0.04); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 1.5rem; margin-top: 2rem; transition: all 0.3s ease;">
        <div class="content-card-header" style="margin-bottom: 1.5rem;">
            <h3 class="content-card-title" style="font-size: 1.25rem; font-weight: 600; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                <i class="fas fa-calendar-alt" style="color: #8b5cf6;"></i> Prochains cours cette semaine
            </h3>
        </div>
        <div class="content-card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                @forelse($prochainsCours ?? [] as $cours)
                <div style="padding: 1rem; background: rgba(255,255,255,0.02); border-radius: 12px; border-left: 3px solid #8b5cf6; transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.transform='translateY(-2px)'"
                     onmouseout="this.style.background='rgba(255,255,255,0.02)'; this.style.transform='translateY(0)'">
                    <p style="font-weight: 600; margin: 0; color: #ffffff;">{{ $cours->cours->nom }}</p>
                    <p style="color: #8b92a3; font-size: 0.875rem; margin: 5px 0;">
                        <i class="fas fa-calendar" style="margin-right: 5px;"></i>
                        {{ $cours->date_debut->format('d/m/Y') }}
                    </p>
                    <p style="color: #8b92a3; font-size: 0.875rem; margin: 0;">
                        <i class="fas fa-clock" style="margin-right: 5px;"></i>
                        {{ $cours->date_debut->format('H:i') }}
                    </p>
                </div>
                @empty
                <p style="color: #8b92a3; text-align: center; grid-column: 1/-1;">Aucun cours programmé cette semaine</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Effet hover sur les icônes des stats
document.querySelectorAll('.stat-card-modern').forEach(card => {
    const icon = card.querySelector('.stat-icon');
    card.addEventListener('mouseenter', () => {
        icon.style.transform = 'scale(1.1) rotate(5deg)';
    });
    card.addEventListener('mouseleave', () => {
        icon.style.transform = 'scale(1) rotate(0deg)';
    });
});
</script>

<style>
/* Effet glow au hover sur les valeurs */
.stat-card-modern:hover .stat-value {
    text-shadow: 
        0 0 20px rgba(255,255,255,0.5),
        0 2px 4px rgba(0,0,0,0.3);
}

/* Animation de pulsation */
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endpush
@endsection
EOF

# 3. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data resources/views/admin/dashboard/
chmod -R 755 resources/views/admin/dashboard/

# 4. Vider le cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan view:clear

echo "✅ Dashboard admin école amélioré avec succès !"
echo ""
echo "🎨 AMÉLIORATIONS APPLIQUÉES :"
echo "- ✅ Cartes avec icônes gradient colorées"
echo "- ✅ Animations au survol identiques au superadmin"
echo "- ✅ Actions rapides avec gradients"
echo "- ✅ Sections Sessions et Membres en attente"
echo "- ✅ Design glassmorphique cohérent"
echo "- ✅ Effets hover sur tous les éléments"
echo ""
echo "🔄 Le dashboard admin école a maintenant le même niveau de qualité que le superadmin !"
