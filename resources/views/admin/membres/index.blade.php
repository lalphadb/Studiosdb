@extends('layouts.admin')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="color: white; font-size: 2rem; margin: 0; font-weight: 600;">Gestion des Membres</h1>
        <p style="color: rgba(255,255,255,0.7); margin: 0.5rem 0 0 0;">0 membre(s) au total</p>
    </div>
    <button style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; cursor: pointer; font-weight: 500;">
        Nouveau Membre
    </button>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: rgba(59,130,246,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(59,130,246,0.3); border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #60a5fa; margin-bottom: 0.5rem;">0</div>
        <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem;">Total Membres</div>
    </div>
    
    <div style="background: rgba(16,185,129,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(16,185,129,0.3); border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #34d399; margin-bottom: 0.5rem;">0</div>
        <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem;">Approuvés</div>
    </div>
    
    <div style="background: rgba(245,158,11,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(245,158,11,0.3); border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #fbbf24; margin-bottom: 0.5rem;">0</div>
        <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem;">En attente</div>
    </div>
    
    <div style="background: rgba(139,92,246,0.2); backdrop-filter: blur(20px); border: 1px solid rgba(139,92,246,0.3); border-radius: 1rem; padding: 2rem; text-align: center;">
        <div style="font-size: 2.5rem; font-weight: 700; color: #a78bfa; margin-bottom: 0.5rem;">0</div>
        <div style="color: rgba(255,255,255,0.8); font-size: 0.875rem;">Ce mois</div>
    </div>
</div>

<!-- Search and Filters -->
<div style="background: rgba(0,0,0,0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1rem; padding: 2rem; margin-bottom: 2rem;">
    <h3 style="color: white; margin: 0 0 1.5rem 0; font-size: 1.1rem;">Filtres et Recherche</h3>
    
    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto auto; gap: 1rem; align-items: end;">
        <input type="text" placeholder="Nom, ville, responsable..." style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 0.5rem; color: white;">
        
        <select style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 0.5rem; color: white;">
            <option>Toutes les écoles</option>
        </select>
        
        <select style="padding: 0.75rem 1rem; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); border-radius: 0.5rem; color: white;">
            <option>Tous les statuts</option>
        </select>
        
        <button style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; cursor: pointer;">
            Filtrer
        </button>
        
        <button style="background: rgba(107,114,128,0.8); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; cursor: pointer;">
            Reset
        </button>
    </div>
</div>

<!-- Data Table -->
<div style="background: rgba(0,0,0,0.3); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); border-radius: 1rem; padding: 2rem;">
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr; gap: 1rem; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 1rem;">
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; font-weight: 500;">MEMBRE</div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; font-weight: 500;">CONTACT</div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; font-weight: 500;">ÉCOLE</div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; font-weight: 500;">STATUT</div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; font-weight: 500;">INSCRIPTION</div>
        <div style="color: rgba(255,255,255,0.6); font-size: 0.875rem; font-weight: 500;">ACTIONS</div>
    </div>
    
    <div style="text-align: center; padding: 3rem; color: rgba(255,255,255,0.6);">
        <div style="font-size: 1.1rem; margin-bottom: 0.5rem;">Aucun membre trouvé</div>
        <div style="font-size: 0.9rem;">Créez votre premier membre ou ajustez vos filtres</div>
    </div>
</div>
@endsection
