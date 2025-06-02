@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="theta-card">
                <div class="alert alert-warning">
                    <h4 class="alert-heading">
                        <i class="bi bi-exclamation-triangle"></i> Aucune école assignée
                    </h4>
                    <p>Votre compte n'est associé à aucune école. Veuillez contacter un administrateur.</p>
                    <hr>
                    <p class="mb-0">
                        En attendant, vous pouvez :
                    </p>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.membres.index') }}" class="btn btn-primary">
                        <i class="bi bi-people"></i> Voir tous les membres
                    </a>
                    <a href="{{ route('admin.cours.index') }}" class="btn btn-info ml-2">
                        <i class="bi bi-calendar3"></i> Voir tous les cours
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
