@extends('layouts.admin')

@section('title', 'Gestion des Thèmes')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>Sélection du Thème d'Interface</h3>
                    <p class="text-muted mb-0">Choisissez le thème visuel pour votre interface d'administration StudiosDB</p>
                </div>
                
                <div class="card-body">
                    <div class="row g-4">
                        @foreach($themes as $themeKey => $themeName)
                        <div class="col-md-6 col-lg-3">
                            <div class="theme-preview-card {{ $currentTheme === $themeKey ? 'active' : '' }}">
                                <div class="theme-preview theme-{{ $themeKey }}">
                                    <div class="preview-header">
                                        <div class="preview-brand">
                                            <i class="fas fa-fist-raised"></i>
                                            <span>Studios Unis</span>
                                        </div>
                                    </div>
                                    <div class="preview-sidebar">
                                        <div class="preview-nav-item active">Dashboard</div>
                                        <div class="preview-nav-item">Écoles</div>
                                        <div class="preview-nav-item">Membres</div>
                                    </div>
                                    <div class="preview-content">
                                        <div class="preview-stats">
                                            <div class="preview-stat">
                                                <span class="number">22</span>
                                                <span class="label">Écoles</span>
                                            </div>
                                            <div class="preview-stat">
                                                <span class="number">1</span>
                                                <span class="label">Membres</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="theme-info">
                                    <h5>{{ $themeName }}</h5>
                                    <p class="theme-description">
                                        @switch($themeKey)
                                            @case('corporate')
                                                Thème professionnel avec palette gris anthracite et accents bleus
                                                @break
                                            @case('industrial')
                                                Esthétique industrielle moderne avec tons bronze et orange cuivré
                                                @break
                                            @case('minimalist')
                                                Design minimaliste épuré avec verts sauge et tons naturels
                                                @break
                                            @case('navy')
                                                Élégance marine professionnelle avec bleus profonds et accents dorés
                                                @break
                                        @endswitch
                                    </p>
                                    
                                    @if($currentTheme === $themeKey)
                                        <span class="badge bg-success">Thème Actuel</span>
                                    @else
                                        <form method="POST" action="{{ route('themes.switch') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="theme" value="{{ $themeKey }}">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                Appliquer ce Thème
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
