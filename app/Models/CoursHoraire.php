<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'notes',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByJour($query, $jour)
    {
        return $query->where('jour', $jour);
    }
}
