<div class="row g-4">
    @forelse($cours as $coursItem)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 text-white cours-card" style="background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s ease;">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: {{ $coursItem->session->couleur ?? '#6c757d' }}20; border-bottom: 2px solid {{ $coursItem->session->couleur ?? '#6c757d' }};">
                    <h5 class="mb-0 text-truncate" style="max-width: 250px;">{{ $coursItem->nom }}</h5>
                    <span class="badge {{ $coursItem->actif ? 'bg-success' : 'bg-secondary' }}">
                        {{ $coursItem->actif ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="fas fa-school me-1"></i>{{ $coursItem->ecole->nom ?? 'N/A' }}
                        </small>
                        
                        @if($coursItem->session)
                            <span class="badge mb-2" style="background-color: {{ $coursItem->session->couleur }};">
                                {{ $coursItem->session->nom }}
                            </span>
                        @endif
                        
                        <small class="d-block">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $coursItem->date_debut_format }}
                            @if($coursItem->date_fin)
                                au {{ $coursItem->date_fin_format }}
                            @endif
                        </small>
                    </div>
                    
                    @if($coursItem->description)
                        <p class="small mb-3 text-white-50">{{ Str::limit($coursItem->description, 80) }}</p>
                    @endif
                    
                    <div class="mb-3">
                        <h6 class="text-info mb-2"><i class="fas fa-clock me-1"></i>Horaires</h6>
                        @if($coursItem->horaires->count() > 0)
                            <div class="horaires-grid">
                                @foreach($coursItem->horaires as $horaire)
                                    <div class="horaire-item">
                                        <strong>{{ ucfirst($horaire->jour) }}</strong>
                                        <span class="text-muted">{{ \substr($horaire->heure_debut, 0, 5) }} - {{ \substr($horaire->heure_fin, 0, 5) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted small">Aucun horaire défini</span>
                        @endif
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="bg-dark p-2 rounded text-center" style="background: rgba(0,0,0,0.3) !important;">
                                <small class="text-muted d-block">Inscrits</small>
                                <strong class="text-info">{{ $coursItem->inscriptions->count() }} / {{ $coursItem->places_max ?: '∞' }}</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-dark p-2 rounded text-center" style="background: rgba(0,0,0,0.3) !important;">
                                <small class="text-muted d-block">Cours/sem</small>
                                <strong class="text-warning">{{ $coursItem->horaires->count() }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    @if($coursItem->tarification_info)
                        <div class="alert alert-info py-2 px-3 mb-0" style="background: rgba(13,202,240,0.1); border: 1px solid rgba(13,202,240,0.3);">
                            <small><i class="fas fa-dollar-sign me-1"></i>{{ Str::limit($coursItem->tarification_info, 50) }}</small>
                        </div>
                    @endif
                </div>
                <div class="card-footer" style="background: rgba(255,255,255,0.05);">
                    <div class="btn-group btn-group-sm w-100">
                        <a href="{{ route('cours.show', $coursItem) }}" 
                           class="btn btn-outline-info" 
                           title="Voir">
                            <i class="fas fa-eye"></i> Voir
                        </a>
                        <a href="{{ route('cours.edit', $coursItem) }}" 
                           class="btn btn-outline-warning" 
                           title="Modifier">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <button type="button" 
                                class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <form action="{{ route('cours.toggle-status', $coursItem) }}" 
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-power-off me-2"></i>
                                        {{ $coursItem->actif ? 'Désactiver' : 'Activer' }}
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('cours.duplicate', $coursItem) }}" 
                                      method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-copy me-2"></i>Dupliquer
                                    </button>
                                </form>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('cours.destroy', $coursItem) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-trash me-2"></i>Supprimer
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card bg-dark text-white text-center py-5" style="backdrop-filter: blur(10px); background: rgba(255,255,255,0.1);">
                <div class="card-body">
                    <i class="fas fa-chalkboard-teacher fa-3x mb-3 text-muted"></i>
                    <p class="mb-0">Aucun cours trouvé</p>
                    <a href="{{ route('cours.create') }}" class="btn btn-info mt-3">
                        <i class="fas fa-plus me-2"></i>Créer votre premier cours
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<style>
.cours-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,212,255,0.3);
}

.horaires-grid {
    display: grid;
    gap: 0.5rem;
}

.horaire-item {
    background: rgba(255,255,255,0.05);
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid rgba(255,255,255,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.875rem;
}

.horaire-item:hover {
    background: rgba(255,255,255,0.08);
}
</style>
