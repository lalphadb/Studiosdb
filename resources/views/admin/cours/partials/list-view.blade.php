<div class="card bg-dark text-white" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>École</th>
                        <th>Session</th>
                        <th>Horaires</th>
                        <th>Places</th>
                        <th>Statut</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cours as $coursItem)
                        <tr>
                            <td>
                                <strong>{{ $coursItem->nom }}</strong>
                                @if($coursItem->description)
                                    <br><small class="text-muted">{{ Str::limit($coursItem->description, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $coursItem->ecole->nom ?? 'N/A' }}</td>
                            <td>
                                @if($coursItem->session)
                                    <span class="badge" style="background-color: {{ $coursItem->session->couleur }};">
                                        {{ $coursItem->session->nom }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($coursItem->horaires->count() > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($coursItem->horaires->take(3) as $horaire)
                                            <span class="badge bg-secondary" style="font-size: 0.7rem;">
                                                {{ ucfirst($horaire->jour) }} {{ \substr($horaire->heure_debut, 0, 5) }}
                                            </span>
                                        @endforeach
                                        @if($coursItem->horaires->count() > 3)
                                            <span class="badge bg-secondary">+{{ $coursItem->horaires->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Aucun</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $coursItem->inscriptions->count() }} / {{ $coursItem->places_max ?: '∞' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $coursItem->actif ? 'success' : 'secondary' }}">
                                    {{ $coursItem->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.cours.show', $coursItem) }}" 
                                       class="btn btn-outline-info" 
                                       title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.cours.edit', $coursItem) }}" 
                                       class="btn btn-outline-warning" 
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.cours.toggle-status', $coursItem) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                                class="btn btn-outline-{{ $coursItem->actif ? 'secondary' : 'success' }} btn-sm"
                                                title="{{ $coursItem->actif ? 'Désactiver' : 'Activer' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-muted"></i>
                                <p class="mb-0">Aucun cours trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
