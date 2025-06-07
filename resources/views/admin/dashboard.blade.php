@extends('layouts.admin')

@section('title', 'Dashboard SuperAdmin')

@section('content')
<!-- Header -->
<div style="margin-bottom: 3rem;">
    <h1 style="font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 0.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
        Dashboard StudiosUnisDB
    </h1>
    <p style="color: rgba(255,255,255,0.8); font-size: 1.1rem;">
        Bienvenue, {{ Auth::user()->name }} 
        <span style="background: rgba(59,130,246,0.3); padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; margin-left: 1rem;">
            {{ Auth::user()->getRoleNames()->first() ?? 'User' }}
        </span>
    </p>
</div>

<!-- Stats Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
    <!-- Utilisateurs Card -->
    <div style="background: rgba(0,0,0,0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; padding: 2rem; transition: all 0.3s ease; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #3b82f6, #1d4ed8);"></div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 3rem; font-weight: 800; color: #60a5fa; line-height: 1;">1</div>
                <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">Utilisateurs</div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                👤
            </div>
        </div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">
            <span style="color: #34d399;">Superadmin actif</span>
        </div>
    </div>

    <!-- Écoles Card -->
    <div style="background: rgba(0,0,0,0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; padding: 2rem; transition: all 0.3s ease; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #10b981, #047857);"></div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 3rem; font-weight: 800; color: #34d399; line-height: 1;">22</div>
                <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">Écoles</div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #10b981, #047857); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                🏫
            </div>
        </div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">
            <span style="color: #34d399;">Toutes configurées</span>
        </div>
    </div>

    <!-- Membres Card -->
    <div style="background: rgba(0,0,0,0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; padding: 2rem; transition: all 0.3s ease; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #8b5cf6, #6d28d9);"></div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 3rem; font-weight: 800; color: #a78bfa; line-height: 1;">0</div>
                <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">Membres</div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #8b5cf6, #6d28d9); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                👥
            </div>
        </div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">
            <span style="color: #fbbf24;">Prochaine étape</span>
        </div>
    </div>

    <!-- Cours Card -->
    <div style="background: rgba(0,0,0,0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1.5rem; padding: 2rem; transition: all 0.3s ease; position: relative; overflow: hidden;">
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem;">
            <div>
                <div style="font-size: 3rem; font-weight: 800; color: #fbbf24; line-height: 1;">0</div>
                <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">Cours</div>
            </div>
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 1rem; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                🥋
            </div>
        </div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem;">
            <span style="color: #fbbf24;">En préparation</span>
        </div>
    </div>
</div>

<!-- Actions Rapides -->
<div style="margin-bottom: 3rem;">
    <h2 style="color: white; font-size: 1.5rem; margin-bottom: 1.5rem;">Actions Rapides</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Gérer Membres -->
        <a href="{{ route('admin.membres.index') }}" style="text-decoration: none;">
            <div style="background: rgba(139,92,246,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(139,92,246,0.3); border-radius: 1rem; padding: 1.5rem; transition: all 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-4px)'; this.style.backgroundColor='rgba(139,92,246,0.3)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.backgroundColor='rgba(139,92,246,0.2)'">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <span style="font-size: 2rem; margin-right: 1rem;">👥</span>
                    <h3 style="color: white; font-size: 1.1rem; margin: 0;">Gérer les Membres</h3>
                </div>
                <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">Ajouter et gérer les membres</p>
            </div>
        </a>

        <!-- Gérer Cours -->
        <a href="{{ route('admin.cours.index') }}" style="text-decoration: none;">
            <div style="background: rgba(245,158,11,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(245,158,11,0.3); border-radius: 1rem; padding: 1.5rem; transition: all 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-4px)'; this.style.backgroundColor='rgba(245,158,11,0.3)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.backgroundColor='rgba(245,158,11,0.2)'">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <span style="font-size: 2rem; margin-right: 1rem;">🥋</span>
                    <h3 style="color: white; font-size: 1.1rem; margin: 0;">Gérer les Cours</h3>
                </div>
                <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">Planifier les cours</p>
            </div>
        </a>

        <!-- Gérer Écoles -->
        <a href="{{ route('admin.ecoles.index') }}" style="text-decoration: none;">
            <div style="background: rgba(16,185,129,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(16,185,129,0.3); border-radius: 1rem; padding: 1.5rem; transition: all 0.3s ease;"
                 onmouseover="this.style.transform='translateY(-4px)'; this.style.backgroundColor='rgba(16,185,129,0.3)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.backgroundColor='rgba(16,185,129,0.2)'">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <span style="font-size: 2rem; margin-right: 1rem;">🏫</span>
                    <h3 style="color: white; font-size: 1.1rem; margin: 0;">Gérer les Écoles</h3>
                </div>
                <p style="color: rgba(255,255,255,0.8); margin: 0; font-size: 0.9rem;">Administrer les 22 écoles</p>
            </div>
        </a>
    </div>
</div>
@endsection
