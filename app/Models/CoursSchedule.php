<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursSchedule extends Model
{
    protected $fillable = [
        'cours_id',
        'jour_semaine',
        'heure_debut',
        'heure_fin',
        'salle',
        'capacite_max',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
}
