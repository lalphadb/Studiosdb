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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'session_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
