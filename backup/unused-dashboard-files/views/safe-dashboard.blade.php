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
