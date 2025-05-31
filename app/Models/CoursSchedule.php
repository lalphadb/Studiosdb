// app/Models/CoursSchedule.php
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
        'capacite_max',
        'salle',
        'actif'
    ];
    
    protected $casts = [
        'actif' => 'boolean',
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
    ];
    
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
    
    public function getJourFormatteAttribute()
    {
        $jours = [
            'lundi' => 'Lundi',
            'mardi' => 'Mardi',
            'mercredi' => 'Mercredi',
            'jeudi' => 'Jeudi',
            'vendredi' => 'Vendredi',
            'samedi' => 'Samedi',
            'dimanche' => 'Dimanche'
        ];
        
        return $jours[$this->jour_semaine] ?? $this->jour_semaine;
    }
    
    public function getCreneauAttribute()
    {
        return $this->heure_debut->format('H:i') . ' - ' . $this->heure_fin->format('H:i');
    }
}
