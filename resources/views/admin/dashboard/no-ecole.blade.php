@extends('layouts.admin')

@section('title', 'Aucune école assignée')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/aurora-grey-theme.css') }}">
@endpush


@section('content')
<div class="container-fluid px-4 py-6">
    <div class="aurora-card text-center">
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-white/5 flex items-center justify-content">
            <i class="fas fa-school text-4xl text-white/30"></i>
        </div>
        
        <h1 class="text-2xl font-bold text-white mb-4">Aucune école assignée</h1>
        <p class="text-secondary mb-6">
            Votre compte n'est pas encore associé à une école. 
            Veuillez contacter l'administrateur pour être assigné à une école.
        </p>
        
        <a href="{{ route('profile.edit') }}" class="btn-aurora">
            Voir mon profil
        </a>
    </div>
</div>
@endsection
