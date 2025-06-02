@extends('layouts.guest')

@section('content')
<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 text-center">
            <h1 class="display-1">404</h1>
            <h2>Page non trouvée</h2>
            <p class="text-muted mb-4">La page que vous recherchez n'existe pas.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                <i class="bi bi-house me-2"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
