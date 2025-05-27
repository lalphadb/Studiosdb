<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursHoraire extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'salle',
        'notes',
        'active',
    ];

    protected $casts = [
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
        'active' => 'boolean',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getJourFrancaisAttribute()
    {
        $jours = [
            'lundi' => 'Lundi',
            'mardi' => 'Mardi', 
            'mercredi' => 'Mercredi',
            'jeudi' => 'Jeudi',
            'vendredi' => 'Vendredi',
            'samedi' => 'Samedi',
            'dimanche' => 'Dimanche',
        ];

        return $jours[$this->jour] ?? $this->jour;
    }
}
