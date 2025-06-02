<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours';

    protected $fillable = [
        'nom',
        'description',
        'ecole_id',
        'session_id',
        'date_debut',
        'date_fin',
        'places_max',
        'tarification_info',
        'actif'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'actif' => 'boolean',
        'places_max' => 'integer'
    ];

    // Relations
    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function session()
    {
        return $this->belongsTo(CoursSession::class, 'session_id');
    }

    public function horaires()
    {
        return $this->hasMany(CoursHoraire::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(InscriptionCours::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    // Accesseurs pour les dates formatées
    public function getDateDebutFormatAttribute()
    {
        return $this->date_debut ? Carbon::parse($this->date_debut)->format('d/m/Y') : null;
    }

    public function getDateFinFormatAttribute()
    {
        return $this->date_fin ? Carbon::parse($this->date_fin)->format('d/m/Y') : null;
    }

    // Accesseur pour les places disponibles
    public function getPlacesDisponiblesAttribute()
    {
        if (!$this->places_max) {
            return null;
        }
        $inscrites = $this->inscriptions()->where('statut', 'confirmee')->count();
        return max(0, $this->places_max - $inscrites);
    }

    // Méthode pour dupliquer un cours
    public function duplicate()
    {
        $newCours = $this->replicate();
        $newCours->nom = $this->nom . ' (Copie)';
        $newCours->save();
        
        // Dupliquer les horaires
        foreach ($this->horaires as $horaire) {
            $newCours->horaires()->create($horaire->toArray());
        }
        
        return $newCours;
    }
}
