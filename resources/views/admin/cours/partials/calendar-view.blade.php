@php
    $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
    $jourLabels = [
        'lundi' => 'Lundi',
        'mardi' => 'Mardi',
        'mercredi' => 'Mercredi',
        'jeudi' => 'Jeudi',
        'vendredi' => 'Vendredi',
        'samedi' => 'Samedi',
        'dimanche' => 'Dimanche'
    ];
    
    // Organiser les cours par jour
    $coursByDay = [];
    foreach($jours as $jour) {
        $coursByDay[$jour] = [];
    }
    
    foreach($cours as $coursItem) {
        if($coursItem->actif) {
            foreach($coursItem->horaires as $horaire) {
                if(isset($coursByDay[$horaire->jour])) {
                    $coursByDay[$horaire->jour][] = [
                        'cours' => $coursItem,
                        'horaire' => $horaire
                    ];
                }
            }
        }
    }
    
    // Trier par heure
    foreach($coursByDay as $jour => &$coursJour) {
        usort($coursJour, function($a, $b) {
            return strcmp($a['horaire']->heure_debut, $b['horaire']->heure_debut);
        });
    }
@endphp

<div class="row g-3">
    @foreach($jours as $jour)
        <div class="col-12">
            <div class="card bg-dark text-white" style="backdrop-filter: blur(15px); background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); border: 1px solid rgba(255,255,255,0.2);">
                <div class="card-header" style="background: rgba(255,255,255,0.1); border-bottom: 2px solid rgba(255,255,255,0.3);">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="fas fa-calendar-day me-3 text-info"></i>
                        {{ $jourLabels[$jour] }}
                        <span class="badge bg-info ms-auto">{{ count($coursByDay[$jour]) }} cours</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($coursByDay[$jour]) > 0)
                        <div class="row g-3">
                            @foreach($coursByDay[$jour] as $item)
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="card h-100 cours-schedule-card" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;">
                                        <div class="card-header py-2" style="background: {{ $item['cours']->session->couleur ?? '#6c757d' }}20; border-bottom: 2px solid {{ $item['cours']->session->couleur ?? '#6c757d' }};">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h6 class="mb-0 text-truncate" style="max-width: 200px;">
                                                    {{ $item['cours']->nom }}
                                                </h6>
                                                <span class="badge bg-dark">
                                                    {{ substr($item['horaire']->heure_debut, 0, 5) }} - 
                                                    {{ substr($item['horaire']->heure_fin, 0, 5) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body py-3">
                                            <div class="small mb-2">
                                                <i class="fas fa-school me-1 text-muted"></i>
                                                {{ $item['cours']->ecole->nom }}
                                            </div>
                                            @if($item['cours']->session)
                                                <div class="small mb-2">
                                                    <i class="fas fa-tag me-1 text-muted"></i>
                                                    <span class="badge" style="background-color: {{ $item['cours']->session->couleur }};">
                                                        {{ $item['cours']->session->nom }}
                                                    </span>
                                                </div>
                                            @endif
                                            <div class="small mb-2">
                                                <i class="fas fa-users me-1 text-muted"></i>
                                                {{ $item['cours']->inscriptions->count() }} / {{ $item['cours']->places_max ?: '∞' }} inscrits
                                            </div>
                                            @if($item['horaire']->salle)
                                                <div class="small">
                                                    <i class="fas fa-door-open me-1 text-muted"></i>
                                                    Salle: {{ $item['horaire']->salle }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer py-2" style="background: rgba(255,255,255,0.05);">
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('admin.cours.show', $item['cours']) }}" 
                                                   class="btn btn-outline-info" 
                                                   title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.cours.edit', $item['cours']) }}" 
                                                   class="btn btn-outline-warning" 
                                                   title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.cours.duplicate', $item['cours']) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-outline-secondary btn-sm"
                                                            title="Dupliquer">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p class="mb-0">Aucun cours programmé ce jour</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

