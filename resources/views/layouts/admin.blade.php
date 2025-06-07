<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - {{ config('app.name', 'Studios Unis DB') }}</title>
    
    <!-- Fonts -->
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS via Vite -->
    @vite(['resources/css/admin.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Sidebar Toggle Mobile -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="admin-layout">
        <!-- Sidebar -->
        <nav class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <i class="fas fa-karate"></i>
                    </div>
                    <div class="sidebar-text">Studios Unis</div>
                </a>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="sidebar-text">Dashboard</span>
                    </a>
                </li>
                
                @if(auth()->user()->hasRole('superadmin'))
                <li>
                    <a href="{{ route('admin.ecoles.index') }}" class="{{ request()->routeIs('admin.ecoles.*') ? 'active' : '' }}">
                        <i class="fas fa-school"></i>
                        <span class="sidebar-text">Écoles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span class="sidebar-text">Utilisateurs</span>
                    </a>
                </li>
                @endif
                
                <li>
                    <a href="{{ route('admin.membres.index') }}" class="{{ request()->routeIs('admin.membres.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span class="sidebar-text">Membres</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.cours.index') }}" class="{{ request()->routeIs('admin.cours.*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span class="sidebar-text">Cours</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.presences.index') }}" class="{{ request()->routeIs('admin.presences.*') ? 'active' : '' }}">
                        <i class="fas fa-check-circle"></i>
                        <span class="sidebar-text">Présences</span>
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('admin.inscriptions.index') }}" class="{{ request()->routeIs('admin.inscriptions.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i>
                        <span class="sidebar-text">Inscriptions</span>
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <div class="user-profile-sidebar">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-name sidebar-text">{{ Auth::user()->name }}</div>
                    <div class="user-role sidebar-text">{{ Auth::user()->getRoleNames()->first() ?? 'User' }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="sidebar-text">Déconnexion</span>
                    </button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="admin-main" id="mainContent">
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('sidebarOverlay');
            
            toggleBtn?.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                } else {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('sidebar-collapsed');
                }
            });
            
            overlay?.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            });
        });
    </script>
</body>
</html>
