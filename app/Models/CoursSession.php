<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursSession extends Model
{
    use HasFactory;

    protected $table = 'cours_sessions';

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
        'active',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'date_limite_inscription' => 'date',
        'inscriptions_actives' => 'boolean',
        'visible' => 'boolean',
        'active' => 'boolean',
    ];

    // Relations
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
        return $this->hasMany(InscriptionCours::class, 'session_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    // Méthodes utilitaires
    public function getTotalInscriptionsAttribute()
    {
        return $this->inscriptions()->where('statut', 'confirmee')->count();
    }

    public function getStatutInscriptionsAttribute()
    {
        if (!$this->inscriptions_actives) {
            return 'Fermées';
        }
        
        if ($this->date_limite_inscription && $this->date_limite_inscription < now()) {
            return 'Expirées';
        }
        
        return 'Ouvertes';
    }
}
