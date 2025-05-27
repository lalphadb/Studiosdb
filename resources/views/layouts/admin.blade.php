<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Studios Unis - Administration')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- NOS NOUVEAUX CSS GLASSMORPHISM -->
    <link rel="stylesheet" href="{{ asset('css/glassmorphism-ultimate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cards-ultimate.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="studios-wrapper">
        
        <!-- Sidebar Glassmorphism -->
        <div class="studios-sidebar" id="sidebar">
            <!-- Brand/Logo -->
            <div class="studios-brand">
                <div class="brand-logo">
                    <i class="fas fa-fist-raised"></i>
                </div>
                <h2 class="brand-title">Studios Unis</h2>
            </div>
            
            <!-- User Panel -->
            <div class="studios-user-panel">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role }}</div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="studios-nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
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
                    <li class="nav-item">
                        <a href="{{ route('admin.sessions.index') }}" class="nav-link {{ request()->routeIs('admin.sessions.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar"></i>
                            <span>Sessions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.cours.index') }}" class="nav-link {{ request()->routeIs('admin.cours.*') ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.presences.index') }}" class="nav-link {{ request()->routeIs('admin.presences.*') ? 'active' : '' }}">
                            <i class="fas fa-check-circle"></i>
                            <span>Présences</span>
                        </a>
                    </li>
                    @if(auth()->user()->role === 'superadmin')
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-user-cog"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    @endif
                </ul>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="studios-main" id="main-content">
            <!-- Top Header -->
            <div class="studios-header">
                <div class="page-title">
                    <i class="fas fa-chart-line"></i>
                    @yield('title', 'Dashboard')
                </div>
                <div class="header-info">
                    <div class="header-date">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
                    <div class="header-time" id="current-time">{{ now()->format('H:i:s') }}</div>
                </div>
            </div>
            
            <!-- Content Area -->
            <div class="studios-content">
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
    // Horloge en temps réel
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('fr-FR');
        document.getElementById('current-time').textContent = timeString;
    }
    
    setInterval(updateTime, 1000);
    
    // Sidebar responsive
    function toggleSidebar() {
        document.querySelector('.studios-sidebar').classList.toggle('open');
    }
    
    // Animation au chargement
    document.addEventListener('DOMContentLoaded', function() {
        // Animer les éléments
        const elements = document.querySelectorAll('.nav-item, .stat-card-ultimate');
        elements.forEach((el, index) => {
            el.style.animationDelay = `${index * 0.1}s`;
        });
    });
    
    // Parallax subtil sur les cartes
    document.addEventListener('mousemove', function(e) {
        const cards = document.querySelectorAll('.stat-card-ultimate');
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const cardX = (rect.left + rect.width / 2) / window.innerWidth;
            const cardY = (rect.top + rect.height / 2) / window.innerHeight;
            
            const rotateX = (mouseY - cardY) * 5;
            const rotateY = (cardX - mouseX) * 5;
            
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });
    });
    </script>
    
    @stack('scripts')
</body>
</html>
