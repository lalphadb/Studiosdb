<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'StudiosDB' }} - Administration</title>
    
    <!-- CSS Unifié -->
    <link href="{{ asset('css/studiosdb-unified.css') }}" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    
    <!-- Chart.js pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-title">StudiosDB</h1>
                <p class="sidebar-subtitle">Administration</p>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-list">
                    <li class="nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-home nav-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.ecoles*') ? 'active' : '' }}">
                        <a href="{{ route('admin.ecoles.index') }}" class="nav-link">
                            <i class="fas fa-school nav-icon"></i>
                            <span>Écoles</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.membres*') ? 'active' : '' }}">
                        <a href="{{ route('admin.membres.index') }}" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            <span>Membres</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.cours.*') ? 'active' : '' }}" 
                           href="{{ route('admin.cours.index') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.cours*') ? 'active' : '' }}">
                        <a href="{{ route('admin.cours.index') }}" class="nav-link">
                            <i class="fas fa-graduation-cap nav-icon"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.sessions*') ? 'active' : '' }}">
                        <a href="{{ route('admin.sessions.index') }}" class="nav-link">
                            <i class="fas fa-calendar nav-icon"></i>
                            <span>Sessions</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.presences*') ? 'active' : '' }}">
                        <a href="{{ route('admin.presences.index') }}" class="nav-link">
                            <i class="fas fa-check-square nav-icon"></i>
                            <span>Présences</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.ceintures*') ? 'active' : '' }}">
                        <a href="{{ route('admin.ceintures.index') }}" class="nav-link">
                            <i class="fas fa-medal nav-icon"></i>
                            <span>Ceintures</span>
                        </a>
                    </li>
                    
                    <li class="nav-item {{ request()->routeIs('admin.seminaires*') ? 'active' : '' }}">
                        <a href="{{ route('admin.seminaires.index') }}" class="nav-link">
                            <i class="fas fa-star nav-icon"></i>
                            <span>Séminaires</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                        <div class="user-role">{{ ucfirst(auth()->user()->role ?? 'superadmin') }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-secondary">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div>
                    <h2 class="header-title">{{ $pageTitle ?? 'Administration' }}</h2>
                </div>
                <div class="header-actions">
                    <button class="notification-btn">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="settings-btn">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </header>
            
            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // Initialiser Feather Icons
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
        
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
        }
    </script>
    
    @stack('scripts')
</body>
</html>

@include('components.footer-loi25')
