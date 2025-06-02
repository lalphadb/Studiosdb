@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <div class="alert alert-danger">
                    <h4 class="alert-heading">
                        <i class="bi bi-x-circle"></i> Erreur
                    </h4>
                    <p>{{ $message ?? 'Une erreur est survenue lors du chargement du dashboard.' }}</p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.ecoles.index') }}" class="btn btn-primary">
                        <i class="bi bi-building"></i> Voir les écoles
                    </a>
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-info ml-2">
                        <i class="bi bi-people"></i> Voir les membres
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
