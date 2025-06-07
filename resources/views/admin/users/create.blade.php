@extends('layouts.admin')

@section('title', 'Créer un Utilisateur')

@section('content')
<div class="admin-header">
    <div class="admin-header-content">
        <h1 class="admin-title">
            <i class="fas fa-user-plus"></i>
            Créer un Utilisateur
        </h1>
        <div class="admin-actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>
</div>

<div class="admin-content">
    <div class="form-container">
        <form method="POST" action="{{ route('admin.users.store') }}" class="admin-form">
            @csrf

            <div class="form-section">
                <h3 class="form-section-title">Informations de base</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name" class="form-label required">Nom complet</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="username" class="form-label required">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" required>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label required">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label required">Confirmer</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="ecole_id" class="form-label required">École</label>
                        <select id="ecole_id" name="ecole_id" class="form-control @error('ecole_id') is-invalid @enderror" required>
                            <option value="">Sélectionner une école</option>
                            @foreach($ecoles as $ecole)
                                <option value="{{ $ecole->id }}" {{ old('ecole_id') == $ecole->id ? 'selected' : '' }}>{{ $ecole->nom }}</option>
                            @endforeach
                        </select>
                        @error('ecole_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label required">Rôle</label>
                        <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                            <option value="">Sélectionner un rôle</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Créer l'utilisateur
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
