@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <h2 class="text-white">Bienvenue sur StudiosDB</h2>
                <p class="text-muted">Chargement du dashboard...</p>
                
                @if(isset($error))
                    <div class="alert alert-warning">
                        {{ $error }}
                    </div>
                @endif
                
                <div class="mt-4">
                    <a href="{{ route('admin.ecoles.index') }}" class="btn btn-primary">
                        Voir les écoles
                    </a>
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-info ml-2">
                        Voir les membres
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
