@extends('layouts.guest')

@section('title', 'Page non trouvée')

@section('content')
<div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
    <div class="text-center">
        <h1 style="font-size: 120px; font-weight: bold; color: #00d4ff; margin: 0;">404</h1>
        <h2 style="color: white; margin-bottom: 20px;">Page non trouvée</h2>
        <p style="color: #7c7c94; margin-bottom: 30px;">La page que vous recherchez n'existe pas.</p>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> Retour à l'accueil
        </a>
    </div>
</div>
@endsection
