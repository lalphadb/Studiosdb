@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <div class="glassmorphic-card p-6">
        <h1 class="text-3xl font-bold text-white mb-6">Dashboard StudiosUnisDB</h1>
        
        @if(isset($user))
        <p class="text-gray-300 mb-4">Bienvenue, {{ $user->name }}!</p>
        @endif
        
        @if(isset($error))
        <div class="bg-red-500/20 border border-red-500/30 text-red-100 p-4 rounded-lg mb-6">
            <h3 class="font-semibold">Erreur détectée:</h3>
            <p class="text-sm">{{ $error }}</p>
        </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.membres.index') }}" class="glassmorphic-card p-6 hover:bg-white/10 transition-all">
                <h3 class="text-xl font-semibold text-white">Membres</h3>
                <p class="text-gray-300">Gérer les membres</p>
            </a>
            
            <a href="{{ route('admin.cours.index') }}" class="glassmorphic-card p-6 hover:bg-white/10 transition-all">
                <h3 class="text-xl font-semibold text-white">Cours</h3>
                <p class="text-gray-300">Gérer les cours</p>
            </a>
            
            <a href="{{ route('admin.ecoles.index') }}" class="glassmorphic-card p-6 hover:bg-white/10 transition-all">
                <h3 class="text-xl font-semibold text-white">Écoles</h3>
                <p class="text-gray-300">Gérer les écoles</p>
            </a>
        </div>
    </div>
</div>
@endsection
