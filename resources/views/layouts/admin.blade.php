<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Studios Unis') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- STYLE GLASSMORPHIQUE INLINE -->
    <style>
        /* =============================================
           STUDIOSUNISDB - GLASSMORPHIC THEME INLINE
           ============================================= */
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --bg-primary: #050505;
            --bg-secondary: #0a0a0a;
            --bg-card: rgba(255, 255, 255, 0.05);
            --bg-hover: rgba(255, 255, 255, 0.08);
            --glass-bg: rgba(255, 255, 255, 0.03);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-blur: blur(10px);
            --gradient-cyan: linear-gradient(135deg, #00d4ff 0%, #00ff88 100%);
            --gradient-orange: linear-gradient(135deg, #ff6b00 0%, #ffaa00 100%);
            --gradient-pink: linear-gradient(135deg, #ff0080 0%, #ff4d94 100%);
            --gradient-purple: linear-gradient(135deg, #7928ca 0%, #ff0080 100%);
            --text-primary: #ffffff;
            --text-secondary: #b4b4c6;
            --text-muted: #7c7c94;
        }
        
        html, body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-primary);
            color: var(--text-secondary);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(0, 212, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 0, 128, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }
        
        .theta-wrapper {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* SIDEBAR */
        .theta-sidebar {
            width: 250px;
            height: 100vh;
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--glass-border);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--glass-border);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: var(--text-primary);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-cyan);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: 700;
            font-size: 18px;
            color: white;
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }
        
        .logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
        }
        
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .nav-item {
            margin: 5px 10px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link:hover {
            color: var(--text-primary);
            background: var(--glass-bg);
            transform: translateX(5px);
        }
        
        .nav-link.active {
            color: var(--text-primary);
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 212, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 212, 255, 0.1);
        }
        
        .nav-icon {
            width: 20px;
            margin-right: 15px;
            font-size: 18px;
        }
        
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--glass-border);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            padding: 12px;
            background: var(--glass-bg);
            border-radius: 12px;
            cursor: pointer;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--gradient-purple);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
            margin-right: 12px;
        }
        
        /* MAIN CONTENT */
        .theta-main {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        
        .theta-header {
            height: 70px;
            background: rgba(10, 10, 10, 0.6);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-left {
            flex: 1;
            display: flex;
            align-items: center;
        }
        
        .menu-toggle {
            display: none;
            width: 40px;
            height: 40px;
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-secondary);
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }
        
        .search-box {
            position: relative;
            max-width: 400px;
            width: 100%;
            margin-left: 30px;
        }
        
        .search-input {
            width: 100%;
            height: 40px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            padding: 0 40px 0 15px;
            color: var(--text-primary);
            font-size: 14px;
        }
        
        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-btn {
            width: 40px;
            height: 40px;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .header-btn:hover {
            background: var(--bg-hover);
            color: var(--text-primary);
            transform: translateY(-2px);
        }
        
        .theta-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 8px;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--text-muted);
        }
        
        .breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            color: #00d4ff;
        }
        
        /* CARDS */
        .theta-card, .stat-card {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 25px;
            position: relative;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .theta-card:hover, .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background: var(--bg-hover);
            border-color: rgba(255, 255, 255, 0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient-cyan);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 212, 255, 0.3);
        }
        
        .stat-icon.success {
            background: var(--gradient-cyan);
        }
        
        .stat-icon.warning {
            background: var(--gradient-orange);
        }
        
        .stat-icon.danger {
            background: var(--gradient-pink);
        }
        
        .stat-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 5px 10px;
        }
        
        .stat-label {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .theta-sidebar {
                transform: translateX(-100%);
            }
            .theta-main {
                margin-left: 0;
            }
            .menu-toggle {
                display: flex;
            }
            .search-box {
                display: none;
            }
        }
    </style>
    
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('css/studiosdb-glassmorphic-complete.css') }}">
<style>
    /* Fix pour empêcher l expansion infinie */
    body { overflow: hidden; }
    .admin-main { overflow-y: auto; max-height: 100vh; }
    .content-area { min-height: auto !important; }
    .theta-content { min-height: auto !important; }
</style>
<link rel="stylesheet" href="{{ asset('css/dashboard-fix.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard-final.css') }}">
</head>
<body>
    <div class="theta-wrapper">
        <!-- Sidebar -->
        <aside class="theta-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <div class="logo-icon">SU</div>
                    <span class="logo-text">Studios Unis</span>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 nav-icon"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.membres.index') }}" class="nav-link">
                            <i class="bi bi-people nav-icon"></i>
                            <span>Membres</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.cours.index') }}" class="nav-link">
                            <i class="bi bi-calendar3 nav-icon"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.ecoles.index') }}" class="nav-link">
                            <i class="bi bi-building nav-icon"></i>
                            <span>Écoles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sessions.index') }}" class="nav-link">
                            <i class="bi bi-calendar-range nav-icon"></i>
                            <span>Sessions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.presences.index') }}" class="nav-link">
                            <i class="bi bi-check-circle nav-icon"></i>
                            <span>Présences</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.inscriptions.index') }}" class="nav-link">
                            <i class="bi bi-person-plus nav-icon"></i>
                            <span>Inscriptions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.seminaires.index') }}" class="nav-link">
                            <i class="bi bi-mortarboard nav-icon"></i>
                            <span>Séminaires</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer" style="padding: 15px; border-top: 1px solid rgba(255,255,255,0.1);">
                <div class="user-profile" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 12px; margin-bottom: 10px; transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.2)'" 
                     onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="user-avatar" style="width: 45px; height: 45px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: 600; color: white; font-size: 16px; box-shadow: 0 4px 15px rgba(139,92,246,0.3);">
                            {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 600; color: #ffffff; font-size: 14px;">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                            <div style="display: flex; align-items: center; gap: 6px; margin-top: 2px;">
                                <span style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; display: inline-block; box-shadow: 0 0 10px rgba(16,185,129,0.5);"></span>
                                <span style="font-size: 12px; color: #8b92a3;">En ligne</span>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" style="width: 100%; padding: 12px; background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #ef4444; border-radius: 10px; cursor: pointer; font-weight: 500; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;"
                            onmouseover="this.style.background='rgba(239,68,68,0.2)'; this.style.borderColor='rgba(239,68,68,0.3)'; this.style.transform='translateY(-2px)'" 
                            onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.borderColor='rgba(239,68,68,0.2)'; this.style.transform='translateY(0)'">
                        <i class="bi bi-box-arrow-right"></i>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="theta-main">
            <header class="theta-header">
                <div class="header-left">
                    <button class="menu-toggle" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                    
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="Rechercher...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
                
                <div class="header-right">
                    <button class="header-btn">
                        <i class="bi bi-bell"></i>
                    </button>
                    <button class="header-btn">
                        <i class="bi bi-fullscreen"></i>
                    </button>
                </div>
            </header>

            <div class="theta-content">
                <div class="page-header">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <nav class="breadcrumb">
                        <a href="{{ route('admin.dashboard') }}">Accueil</a>
                        <i class="bi bi-chevron-right"></i>
                        <span>@yield('breadcrumb', 'Dashboard')</span>
                    </nav>
                </div>

                @if(session('success'))
                    <div class="alert alert-success" style="padding: 15px; background: rgba(0, 255, 136, 0.1); border: 1px solid rgba(0, 255, 136, 0.3); color: #00ff88; border-radius: 8px; margin-bottom: 20px;">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
            <footer class="admin-footer mt-auto">
                <p class="mb-0">© {{ date('Y') }} Studios Unis - Conformité Loi 25 du Québec</p>
            </footer>
        </main>
    </div>

    <!-- Footer -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.style.transform = sidebar.style.transform === 'translateX(0px)' ? 'translateX(-100%)' : 'translateX(0px)';
        }
    </script>
    
    @stack('scripts')
<script src="{{ asset('js/theta-fix.js') }}"></script>
</body>
</html>
    <link rel="stylesheet" href="{{ asset("css/theme-fixes.css") }}">
