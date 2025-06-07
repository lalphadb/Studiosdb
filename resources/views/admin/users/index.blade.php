@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">
            <i class="fas fa-users"></i>
            Gestion des Utilisateurs
        </h1>
        <div class="admin-actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Nouvel Utilisateur
            </a>
        </div>
    </div>
</div>

<div class="admin-content">
    <!-- Statistiques des utilisateurs -->
    <div class="stats-grid mb-6">
        <div class="stat-card">
            <div class="stat-icon bg-red-500">
                <i class="fas fa-crown"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $users->where('roles.0.name', 'superadmin')->count() }}</h3>
                <p>Super Admins</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-orange-500">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $users->where('roles.0.name', 'admin')->count() }}</h3>
                <p>Admins d'École</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-blue-500">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $users->where('roles.0.name', 'instructeur')->count() }}</h3>
                <p>Instructeurs</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-green-500">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $users->where('roles.0.name', 'user')->count() }}</h3>
                <p>Utilisateurs</p>
            </div>
        </div>
    </div>

    <!-- Section Super Admins -->
    @if(auth()->user()->hasRole('superadmin'))
    <div class="user-section mb-8">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-crown text-red-400"></i>
                Super Administrateurs
            </h2>
        </div>
        <div class="users-grid">
            @foreach($users->filter(function($user) { return $user->hasRole('superadmin'); }) as $user)
            <div class="user-card superadmin">
                <div class="user-avatar">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-email">{{ $user->email }}</p>
                    <div class="user-meta">
                        <span class="role-badge superadmin">Super Admin</span>
                        <span class="status-badge {{ $user->active ? 'active' : 'inactive' }}">
                            {{ $user->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="user-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Section Admins d'École -->
    <div class="user-section mb-8">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-user-tie text-orange-400"></i>
                Administrateurs d'École
            </h2>
        </div>
        <div class="users-grid">
            @foreach($users->filter(function($user) { return $user->hasRole('admin'); }) as $user)
            <div class="user-card admin">
                <div class="user-avatar">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-email">{{ $user->email }}</p>
                    <div class="user-meta">
                        <span class="role-badge admin">Admin École</span>
                        @if($user->ecole)
                            <span class="school-badge">{{ $user->ecole->nom }}</span>
                        @endif
                        <span class="status-badge {{ $user->active ? 'active' : 'inactive' }}">
                            {{ $user->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="user-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section Instructeurs -->
    <div class="user-section mb-8">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-chalkboard-teacher text-blue-400"></i>
                Instructeurs
            </h2>
        </div>
        <div class="users-grid">
            @foreach($users->filter(function($user) { return $user->hasRole('instructeur'); }) as $user)
            <div class="user-card instructeur">
                <div class="user-avatar">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-email">{{ $user->email }}</p>
                    <div class="user-meta">
                        <span class="role-badge instructeur">Instructeur</span>
                        @if($user->ecole)
                            <span class="school-badge">{{ $user->ecole->nom }}</span>
                        @endif
                        <span class="status-badge {{ $user->active ? 'active' : 'inactive' }}">
                            {{ $user->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="user-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Section Utilisateurs -->
    <div class="user-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="fas fa-users text-green-400"></i>
                Utilisateurs
            </h2>
        </div>
        <div class="users-grid">
            @foreach($users->filter(function($user) { return $user->hasRole('user'); }) as $user)
            <div class="user-card user">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>
                    <p class="user-email">{{ $user->email }}</p>
                    <div class="user-meta">
                        <span class="role-badge user">Utilisateur</span>
                        @if($user->ecole)
                            <span class="school-badge">{{ $user->ecole->nom }}</span>
                        @endif
                        <span class="status-badge {{ $user->active ? 'active' : 'inactive' }}">
                            {{ $user->active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="user-actions">
                    <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit" title="Modifier">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Supprimer">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
/* Styles pour l'interface utilisateurs moderne */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.stat-info h3 {
    font-size: 2rem;
    font-weight: bold;
    color: white;
    margin: 0;
}

.stat-info p {
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    font-size: 0.9rem;
}

.user-section {
    margin-bottom: 2rem;
}

.section-header {
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.users-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.user-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.user-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.user-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.user-card.superadmin .user-avatar { background: linear-gradient(135deg, #ef4444, #dc2626); }
.user-card.admin .user-avatar { background: linear-gradient(135deg, #f97316, #ea580c); }
.user-card.instructeur .user-avatar { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.user-card.user .user-avatar { background: linear-gradient(135deg, #10b981, #059669); }

.user-info {
    flex: 1;
}

.user-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    margin: 0 0 0.25rem 0;
}

.user-email {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    margin: 0 0 0.5rem 0;
}

.user-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.role-badge, .school-badge, .status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}

.role-badge.superadmin { background: rgba(239, 68, 68, 0.2); color: #fca5a5; }
.role-badge.admin { background: rgba(249, 115, 22, 0.2); color: #fdba74; }
.role-badge.instructeur { background: rgba(59, 130, 246, 0.2); color: #93c5fd; }
.role-badge.user { background: rgba(16, 185, 129, 0.2); color: #6ee7b7; }

.school-badge {
    background: rgba(168, 85, 247, 0.2);
    color: #c4b5fd;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.2);
    color: #86efac;
}

.status-badge.inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.user-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.action-btn.edit {
    background: rgba(59, 130, 246, 0.2);
    color: #93c5fd;
    text-decoration: none;
}

.action-btn.edit:hover {
    background: rgba(59, 130, 246, 0.3);
    transform: scale(1.05);
}

.action-btn.delete {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.action-btn.delete:hover {
    background: rgba(239, 68, 68, 0.3);
    transform: scale(1.05);
}
</style>
@endsection
