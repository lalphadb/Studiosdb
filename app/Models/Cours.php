<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'jours', 'date_debut', 'date_fin', 
        'places_max', 'ecole_id', 'session_id', 'instructeur', 
        'niveau', 'tarif', 'statut'
    ];

    protected $casts = [
        'jours' => 'array',
        'date_debut' => 'date',
        'date_fin' => 'date',
        'tarif' => 'decimal:2'
    ];

    // ✅ RELATIONS
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

    public function membres()
    {
        return $this->belongsToMany(Membre::class, 'inscription_cours')
                    ->withPivot(['statut', 'date_inscription', 'montant_paye', 'notes'])
                    ->withTimestamps();
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    // ✅ SCOPES
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }
}
