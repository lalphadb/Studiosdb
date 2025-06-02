@extends('layouts.admin')

@section('title', 'Gestion des Thèmes')

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

<style>
.theme-preview-card {
    border: 2px solid transparent;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.theme-preview-card.active {
    border-color: #007bff;
    box-shadow: 0 4px 20px rgba(0, 123, 255, 0.2);
}

.theme-preview {
    height: 200px;
    position: relative;
    overflow: hidden;
}

.theme-corporate {
    background: linear-gradient(135deg, #1a1d23 0%, #242831 100%);
}

.theme-industrial {
    background: radial-gradient(ellipse at top, #161b22 0%, #0d1117 70%);
}

.theme-minimalist {
    background: linear-gradient(135deg, #1c1f1a 0%, #252822 50%, #2d312a 100%);
}

.theme-navy {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

.preview-header {
    padding: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.preview-brand {
    color: white;
    font-weight: bold;
    font-size: 0.9rem;
}

.preview-sidebar {
    position: absolute;
    left: 0;
    top: 45px;
    width: 80px;
    height: calc(100% - 45px);
    background: rgba(0,0,0,0.2);
    padding: 10px 5px;
}

.preview-nav-item {
    color: rgba(255,255,255,0.7);
    font-size: 0.7rem;
    padding: 5px 8px;
    margin: 2px 0;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.preview-nav-item.active {
    background: rgba(255,255,255,0.1);
    color: white;
}

.preview-content {
    position: absolute;
    right: 10px;
    top: 60px;
    left: 90px;
}

.preview-stats {
    display: flex;
    gap: 15px;
}

.preview-stat {
    background: rgba(255,255,255,0.1);
    padding: 8px 12px;
    border-radius: 6px;
    text-align: center;
    color: white;
}

.preview-stat .number {
    display: block;
    font-weight: bold;
    font-size: 1.2rem;
}

.preview-stat .label {
    font-size: 0.7rem;
    opacity: 0.8;
}

.theme-info {
    padding: 15px;
}

.theme-description {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 10px;
}
</style>
@endsection
