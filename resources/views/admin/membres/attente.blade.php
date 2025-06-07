@extends('layouts.admin')

@section('title', 'Membres en Attente')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="text-center py-5">
        <h2 class="text-white mb-3">Membres en Attente d'Approbation</h2>
        <p class="text-light">Cette page est en cours de développement.</p>
        <a href="{{ route('admin.membres.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i>
            Retour à la liste
        </a>
    </div>
</div>
@endsection
