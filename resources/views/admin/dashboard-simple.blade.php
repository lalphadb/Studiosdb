@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
<div class="space-y-6">
    <!-- Message de bienvenue -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg p-6 text-white">
        <h1 class="text-2xl font-bold">Bienvenue dans Studios Unis ! 👋</h1>
        <p class="text-blue-100 mt-1">
            Connecté en tant que : <strong>{{ $user->name }}</strong> ({{ $user->role }})
        </p>
        @if(isset($user->ecole->nom))
        <p class="text-blue-100">École : {{ $user->ecole->nom }}</p>
        @endif
    </div>

    <!-- Menu principal -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('admin.membres.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Membres</h3>
                    <p class="text-gray-600">Gérer les membres</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.cours.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Cours</h3>
                    <p class="text-gray-600">Gérer les cours</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.sessions.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Sessions</h3>
                    <p class="text-gray-600">Gérer les sessions</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.ecoles.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Écoles</h3>
                    <p class="text-gray-600">Gérer les écoles</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.presences.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Présences</h3>
                    <p class="text-gray-600">Prendre les présences</p>
                </div>
            </div>
        </a>

        @if($user->role === 'superadmin')
        <a href="{{ route('admin.users.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gray-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Utilisateurs</h3>
                    <p class="text-gray-600">Gérer les utilisateurs</p>
                </div>
            </div>
        </a>
        @endif
    </div>

    @if(isset($error))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
        <strong>Note :</strong> Dashboard en mode simplifié (erreur DB en cours de résolution)
        <details class="mt-2">
            <summary class="cursor-pointer">Détails de l'erreur</summary>
            <pre class="text-xs mt-2 bg-yellow-50 p-2 rounded">{{ $error }}</pre>
        </details>
    </div>
    @endif
</div>
@endsection
