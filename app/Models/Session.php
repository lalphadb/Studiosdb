<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'date_debut',
        'date_fin',
        'places_max',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(InscriptionCours::class);
    }
}
