@extends('layouts.guest')

@section('title', 'Inscription - Portes Ouvertes')

@section('content')
<div class="min-h-screen py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <div class="aurora-card p-8">
                <h1 class="text-3xl font-bold mb-6">Inscription aux Portes Ouvertes</h1>
                
                @if(session('success'))
                    <div class="alert alert-success mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('portes-ouvertes.register') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">École</label>
                        <select name="ecole_id" class="form-select" required>
                            <option value="">Choisir une école</option>
                            @foreach(\App\Models\Ecole::where('statut', 'actif')->get() as $ecole)
                                <option value="{{ $ecole->id }}">{{ $ecole->nom }} - {{ $ecole->ville }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-full">
                        S'inscrire aux portes ouvertes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
