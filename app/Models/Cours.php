<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours';

    protected $fillable = [
        'nom',
        'description', 
        'date_debut',
        'date_fin',
        'places_max',
        'ecole_id',
        'session_id',
        'instructeur',
        'niveau',
        'tarif',
        'statut',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'tarif' => 'decimal:2',
    ];

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

    public function scopeActif($query)
    {
        return $query->where('statut', 'actif');
    }

    public function getPlacesRestantesAttribute()
    {
        return $this->places_max - $this->inscriptions()->where('statut', 'confirmee')->count();
    }
}
