<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CoursHoraire extends Model
{
    use HasFactory;

    protected $table = 'cours_horaires';

    protected $fillable = [
        'cours_id',
        'jour',
        'heure_debut',
        'heure_fin',
        'salle',
        'active'
    ];

    protected $casts = [
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
        'active' => 'boolean'
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    // Accesseurs pour les heures formatées
    public function getHeureDebutFormatAttribute()
    {
        return $this->heure_debut ? Carbon::parse($this->heure_debut)->format('H:i') : null;
    }

    public function getHeureFinFormatAttribute()
    {
        return $this->heure_fin ? Carbon::parse($this->heure_fin)->format('H:i') : null;
    }
}
