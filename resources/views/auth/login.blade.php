@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <!-- Header avec logo -->
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 4rem; height: 4rem; background: linear-gradient(135deg, #667589, #162a44); border-radius: 1rem; margin-bottom: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
            <span style="color: white; font-weight: bold; font-size: 1.25rem;">SU</span>
        </div>
        <h1 style="font-size: 2rem; font-weight: bold; color: white; margin-bottom: 0.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">Studios Unis</h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 1rem;">Connexion à votre compte</p>
    </div>

    @if (session('status'))
        <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #4ade80; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; text-align: center;">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Adresse email</label>
            <input 
                type="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                autofocus 
                placeholder="votre@email.com"
                class="form-input">
            @if($errors->has('email'))
                <span class="form-error">{{ $errors->first('email') }}</span>
            @endif
        </div>
        
        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input 
                type="password" 
                name="password" 
                required 
                placeholder="••••••••"
                class="form-input">
            @if($errors->has('password'))
                <span class="form-error">{{ $errors->first('password') }}</span>
            @endif
        </div>
        
        <div class="form-group">
            <label class="form-check">
                <input type="checkbox" name="remember" class="form-check-input">
                <span class="form-check-label">Se souvenir de moi</span>
            </label>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-auth">
                Se connecter
            </button>
        </div>
        
        <div class="auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">
                    Mot de passe oublié ?
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="auth-link">
                    Nouveau membre ? S'inscrire
                </a>
            @endif
            <a href="{{ url('/') }}" class="auth-link">
                ← Retour à l'accueil
            </a>
        </div>
    </form>
</div>
@endsection
