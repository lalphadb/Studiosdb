#!/bin/bash
# fix-dashboard-layout.sh

echo "🎨 CORRECTION DU LAYOUT DU DASHBOARD"
echo "===================================="

# 1. Corriger le CSS dans le layout admin
echo "📝 Mise à jour du layout admin avec CSS corrigé..."
cat > resources/views/layouts/admin-fixed.blade.php << 'EOF'
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
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #050505;
            color: #ffffff;
            overflow-x: hidden;
        }
        
        /* Layout wrapper */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: rgba(10, 10, 10, 0.95);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #00d4ff, #00ff88);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: 700;
            color: #000;
        }
        
        .nav-menu {
            list-style: none;
            padding: 20px 15px;
        }
        
        .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #b4b4c6;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }
        
        .nav-link.active {
            background: rgba(0, 212, 255, 0.1);
            color: #00d4ff;
            border: 1px solid rgba(0, 212, 255, 0.2);
        }
        
        .nav-icon {
            margin-right: 12px;
            font-size: 18px;
        }
        
        /* Main content */
        .admin-main {
            flex: 1;
            margin-left: 250px;
            background: #0a0a0a;
            min-height: 100vh;
        }
        
        .admin-header {
            background: rgba(10, 10, 10, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }
        
        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            color: #7c7c94;
        }
        
        .content-area {
            padding: 30px;
        }
        
        /* Cards */
        .theta-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
        }
        
        .stat-icon.success { background: linear-gradient(135deg, #00d4ff, #00ff88); }
        .stat-icon.warning { background: linear-gradient(135deg, #ff6b00, #ffaa00); }
        .stat-icon.danger { background: linear-gradient(135deg, #ff0080, #ff4d94); }
        
        /* Footer */
        .admin-footer {
            background: rgba(10, 10, 10, 0.95);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 30px;
            text-align: center;
            color: #7c7c94;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                    <div class="logo-icon">SU</div>
                    <span class="logo-text">Studios Unis</span>
                </a>
            </div>
            
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 nav-icon"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.membres.index') }}" class="nav-link {{ request()->routeIs('admin.membres*') ? 'active' : '' }}">
                            <i class="bi bi-people nav-icon"></i>
                            <span>Membres</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.cours.index') }}" class="nav-link {{ request()->routeIs('admin.cours*') ? 'active' : '' }}">
                            <i class="bi bi-calendar3 nav-icon"></i>
                            <span>Cours</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.ecoles.index') }}" class="nav-link {{ request()->routeIs('admin.ecoles*') ? 'active' : '' }}">
                            <i class="bi bi-building nav-icon"></i>
                            <span>Écoles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sessions.index') }}" class="nav-link {{ request()->routeIs('admin.sessions*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-range nav-icon"></i>
                            <span>Sessions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.presences.index') }}" class="nav-link {{ request()->routeIs('admin.presences*') ? 'active' : '' }}">
                            <i class="bi bi-check-circle nav-icon"></i>
                            <span>Présences</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.inscriptions.index') }}" class="nav-link {{ request()->routeIs('admin.inscriptions*') ? 'active' : '' }}">
                            <i class="bi bi-person-plus nav-icon"></i>
                            <span>Inscriptions</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.seminaires.index') }}" class="nav-link {{ request()->routeIs('admin.seminaires*') ? 'active' : '' }}">
                            <i class="bi bi-mortarboard nav-icon"></i>
                            <span>Séminaires</span>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer p-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-box-arrow-right"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Accueil</a></li>
                                <li class="breadcrumb-item active">@yield('breadcrumb', 'Dashboard')</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <span class="text-muted">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
            
            <footer class="admin-footer">
                <p class="mb-0">© {{ date('Y') }} Studios Unis - Tous droits réservés</p>
            </footer>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
EOF

# 2. Remplacer l'ancien layout
echo "🔄 Remplacement du layout..."
mv resources/views/layouts/admin.blade.php resources/views/layouts/admin.blade.php.backup-$(date +%Y%m%d-%H%M%S)
mv resources/views/layouts/admin-fixed.blade.php resources/views/layouts/admin.blade.php

# 3. Permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data resources/views/layouts/
chmod -R 755 resources/views/layouts/

# 4. Vider le cache
echo "🧹 Nettoyage du cache..."
php artisan cache:clear
php artisan view:clear

echo "✅ Layout corrigé !"
echo ""
echo "🔄 Rafraîchissez la page pour voir les changements"
