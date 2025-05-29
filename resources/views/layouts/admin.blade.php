<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Studios Unis - Administration')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- VOS CSS AVEC TIMESTAMP POUR FORCER LE RECHARGEMENT -->
     <link rel="stylesheet" href="{{ asset('css/studios-theme-unified.css') }}?v={{ time() }}">    
    @stack('styles')
</head>
<body>
    <div class="studios-wrapper">
        
        <!-- Sidebar Moderne -->
        <aside class="studios-sidebar" id="sidebar">
            <!-- Brand -->
            <div class="studios-brand">
                <div class="brand-logo">
                    <i class="fas fa-fist-raised"></i>
                </div>
                <h2 class="brand-title">Studios Unis</h2>
            </div>
            
            <!-- Profile utilisateur -->
            <div class="studios-user-panel">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="studios-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.ecoles.index') }}" class="nav-link {{ request()->routeIs('admin.ecoles.*') ? 'active' : '' }}">
                            <i class="fas fa-building"></i>
                            <span>Écoles</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.membres.index') }}" class="nav-link {{ request()->routeIs('admin.membres.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Membres</span>
                            @if(($membresEnAttente ?? 0) > 0)
                                <span class="nav-badge">{{ $membresEnAttente }}</span>
                            @endif
                        </a>
                    </li>
                    
                    @if(Route::has('admin.sessions.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.sessions.index') }}" class="nav-link {{ request()->routeIs('admin.sessions.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar"></i>
                            <span>Sessions</span>
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('admin.cours.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.cours.index') }}" class="nav-link {{ request()->routeIs('admin.cours.*') ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    @endif
                    
                    @if(Route::has('admin.presences.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.presences.index') }}" class="nav-link {{ request()->routeIs('admin.presences.*') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            <span>Présences</span>
                        </a>
                    </li>
                    @endif
                    
                    @if(auth()->user()->role === 'superadmin' && Route::has('admin.users.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-user-cog"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    @endif
                </ul>
                
                <!-- Bouton Déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </nav>
        </aside>
        
        <!-- Contenu principal -->
        <div class="studios-main" id="main-content">
            <!-- Header moderne -->
            <div class="studios-header">
                <div class="page-title">
                    <i class="fas fa-{{ request()->routeIs('admin.dashboard') ? 'chart-line' : (request()->routeIs('admin.ecoles.*') ? 'building' : (request()->routeIs('admin.membres.*') ? 'users' : 'cog')) }}"></i>
                    @yield('title', 'Dashboard')
                </div>
                <div class="header-info">
                    <div class="header-date">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
                    <div class="header-time" id="current-time">{{ now()->format('H:i:s') }}</div>
                </div>
            </div>
            
            <!-- Zone de contenu -->
            <div class="studios-content">
                <!-- Messages Flash -->
                @if(session('success'))
                <div class="alert-glass-ultimate alert-success-glass">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert-glass-ultimate alert-danger-glass">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>{{ session('error') }}</div>
                </div>
                @endif
                
                @if($errors->any())
                <div class="alert-glass-ultimate alert-warning-glass">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Horloge temps réel
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR');
        const timeElement = document.getElementById('current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    
    setInterval(updateTime, 1000);
    
    // Debug : vérifier que les CSS sont chargés
    console.log('Layout admin chargé avec nouveaux CSS');
    </script>
    
    @stack('scripts')
</body>
</html>
