@extends('layouts.admin')

@section('title', 'Erreur Dashboard')

@section('content')
<div class="container-fluid px-4 py-6">
    <div class="aurora-card">
        <h1 class="text-2xl font-bold text-red-400 mb-4">Erreur Dashboard</h1>
        <p class="text-white mb-4">Une erreur s'est produite :</p>
        <pre class="bg-gray-800 p-4 rounded text-red-300">{{ $error ?? 'Erreur inconnue' }}</pre>
        
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-white mb-2">Informations de debug :</h3>
            <ul class="text-gray-300">
                <li>Utilisateur : {{ auth()->user()->name }}</li>
                <li>ID : {{ auth()->user()->id }}</li>
                <li>École ID : {{ auth()->user()->ecole_id ?? 'Non assigné' }}</li>
                <li>Rôles : {{ auth()->user()->getRoleNames()->implode(', ') }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection
