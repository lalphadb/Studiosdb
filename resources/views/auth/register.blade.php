@extends('layouts.guest')

@section('content')
<div class="auth-card">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 4rem; height: 4rem; background: linear-gradient(135deg, #667589, #162a44); border-radius: 1rem; margin-bottom: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
            <span style="color: white; font-weight: bold; font-size: 1.25rem;">SU</span>
        </div>
        <h1 style="color: white; font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Inscription</h1>
        <p style="color: rgba(255,255,255,0.8);">Créer votre compte membre</p>
    </div>
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label">Nom complet</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="form-input">
            @if($errors->has('name'))
                <span class="form-error">{{ $errors->first('name') }}</span>
            @endif
        </div>
        
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required class="form-input">
            @if($errors->has('email'))
                <span class="form-error">{{ $errors->first('email') }}</span>
            @endif
        </div>
        
        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" required class="form-input">
            @if($errors->has('password'))
                <span class="form-error">{{ $errors->first('password') }}</span>
            @endif
        </div>
        
        <div class="form-group">
            <label class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required class="form-input">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-auth">
                Créer mon compte
            </button>
        </div>
        
        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">
                Déjà membre ? Se connecter
            </a>
        </div>
    </form>
</div>
@endsection
