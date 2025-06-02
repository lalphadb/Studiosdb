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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --bg-primary: #0f1419;
            --bg-secondary: #1a1f26;
            --bg-card: #1e2329;
            --text-primary: #ffffff;
            --text-secondary: #8b92a3;
            --accent-blue: #3b82f6;
            --accent-green: #10b981;
            --accent-orange: #f59e0b;
            --accent-red: #ef4444;
            --accent-purple: #8b5cf6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            overflow-x: hidden;
        }
        
        /* Top Navigation */
        .top-nav {
            background: var(--bg-secondary);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .logo {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        /* Main Container */
        .dashboard-container {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .dashboard-header {
            margin-bottom: 2rem;
        }
        
        .dashboard-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .dashboard-subtitle {
            color: var(--text-secondary);
        }
        
        .date-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-top: 1rem;
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        
        .stat-card.blue::before { background: var(--accent-blue); }
        .stat-card.green::before { background: var(--accent-green); }
        .stat-card.orange::before { background: var(--accent-orange); }
        .stat-card.red::before { background: var(--accent-red); }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
        }
        
        .stat-icon.blue { background: rgba(59, 130, 246, 0.2); color: var(--accent-blue); }
        .stat-icon.green { background: rgba(16, 185, 129, 0.2); color: var(--accent-green); }
        .stat-icon.orange { background: rgba(245, 158, 11, 0.2); color: var(--accent-orange); }
        .stat-icon.red { background: rgba(239, 68, 68, 0.2); color: var(--accent-red); }
        
        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            margin-top: 1rem;
        }
        
        .stat-link:hover {
            color: var(--text-primary);
        }
        
        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
        
        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .content-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1.5rem;
        }
        
        .content-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .content-title {
            font-size: 1.125rem;
            font-weight: 600;
        }
        
        /* Table Styles */
        .modern-table {
            width: 100%;
        }
        
        .modern-table th {
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-secondary);
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .modern-table td {
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        
        .member-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .member-avatar {
            width: 40px;
            height: 40px;
            background: var(--accent-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .member-name {
            font-weight: 500;
        }
        
        .member-date {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }
        
        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge.active {
            background: rgba(16, 185, 129, 0.2);
            color: var(--accent-green);
        }
        
        .badge.pending {
            background: rgba(245, 158, 11, 0.2);
            color: var(--accent-orange);
        }
        
        /* Actions */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            color: var(--text-secondary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .btn-icon:hover {
            background: rgba(255,255,255,0.2);
            color: var(--text-primary);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: var(--text-secondary);
        }
        
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="logo">
            <span>Studios Unis</span>
        </div>
        
        <div class="user-info">
            <button class="btn-icon">
                <i class="fa fa-bell"></i>
            </button>
            <div class="user-avatar">
                {{ substr(auth()->user()->name ?? 'U', 0, 2) }}
            </div>
            <span>{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="dashboard-container">
        @yield('content')
    </main>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
