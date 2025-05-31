@extends('layouts.guest')

@section('title', 'Connexion - Studios Unis')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <div class="auth-logo">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1 class="auth-title">Studios Unis</h1>
        <p class="auth-subtitle">Connectez-vous à votre espace</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Adresse email</label>
            <input type="email" 
                   class="form-control" 
                   name="email" 
                   value="{{ old('email') }}"
                   placeholder="votre@email.com"
                   required 
                   autofocus>
        </div>

        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" 
                   class="form-control" 
                   name="password" 
                   placeholder="••••••••"
                   required>
        </div>

        <div class="form-group">
            <label class="custom-checkbox">
                <input type="checkbox" name="remember">
                <span>Se souvenir de moi</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-full">
            <i class="fas fa-sign-in-alt"></i>
            Se connecter
        </button>

        @if (Route::has('password.request'))
            <div class="text-center mt-4">
                <a href="{{ route('password.request') }}" class="text-sm">
                    Mot de passe oublié ?
                </a>
            </div>
        @endif
    </form>
</div>
@endsection
