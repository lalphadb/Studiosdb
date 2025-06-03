<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cours extends Model
{
    use HasFactory;

    protected $table = 'cours';

    protected $fillable = [
        'nom',
        'description',
        'ecole_id',
        'session_id',
        'type_cours',
        'type',
        'capacite_max',
        'duree_minutes',
        'jours',
        'actif'
    ];

    protected $casts = [
        'jours' => 'array',
        'actif' => 'boolean',
    ];

    public function ecole(): BelongsTo
    {
        return $this->belongsTo(Ecole::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(CoursSession::class, 'session_id');
    }

    public function horaires(): HasMany
    {
        return $this->hasMany(CoursHoraire::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(InscriptionCours::class);
    }

    public function membres(): BelongsToMany
    {
        return $this->belongsToMany(Membre::class, 'inscriptions_cours')
                    ->withPivot('date_inscription', 'statut')
                    ->withTimestamps();
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }
}
