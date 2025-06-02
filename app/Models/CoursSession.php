<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecole_id',
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'mois',
        'inscriptions_actives',
        'visible',
        'date_limite_inscription',
        'couleur',
        'active'
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_limite_inscription' => 'date',
        'inscriptions_actives' => 'boolean',
        'visible' => 'boolean',
        'active' => 'boolean'
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'session_id');
    }

    public function inscriptions()
    {
        return $this->hasManyThrough(
            InscriptionCours::class,
            Cours::class,
            'session_id',
            'cours_id'
        );
    }

    // Vérifier si la session est active
    public function getEstActiveAttribute()
    {
        return $this->active && now()->between($this->date_debut, $this->date_fin);
    }

    // Obtenir le statut de la session
    public function getStatutAttribute()
    {
        if (!$this->active) {
            return 'inactive';
        }
        
        $now = now();
        if ($now->lt($this->date_debut)) {
            return 'à venir';
        } elseif ($now->gt($this->date_fin)) {
            return 'terminée';
        } else {
            return 'en cours';
        }
    }

    // Vérifier si les inscriptions sont ouvertes
    public function getInscriptionsOuvertesAttribute()
    {
        if (!$this->inscriptions_actives || !$this->active) {
            return false;
        }
        
        if ($this->date_limite_inscription) {
            return now()->lte($this->date_limite_inscription);
        }
        
        return now()->lte($this->date_fin);
    }

    // Scope pour les sessions visibles
    public function scopeVisibles($query)
    {
        return $query->where('visible', true);
    }

    // Scope pour les sessions actives
    public function scopeActives($query)
    {
        return $query->where('active', true);
    }
}
