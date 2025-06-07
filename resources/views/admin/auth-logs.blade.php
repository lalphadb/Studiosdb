{{-- resources/views/admin/auth-logs.blade.php --}}
@extends('layouts.admin')

@push("styles")
<link rel="stylesheet" href="{{ asset("css/aurora-grey-theme.css") }}">
@endpush

@section('content')
<div class="container-fluid">
    <h1>Historique des Connexions</h1>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>IP</th>
                        <th>Date/Heure</th>
                        <th>Durée Session</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity->causer->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-{{ $activity->event === 'auth.login' ? 'success' : ($activity->event === 'auth.failed' ? 'danger' : 'info') }}">
                                {{ $activity->description }}
                            </span>
                        </td>
                        <td>{{ $activity->properties['ip'] ?? 'N/A' }}</td>
                        <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $activity->properties['session_duration_minutes'] ?? '-' }} min</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
