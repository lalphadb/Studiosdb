<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membre extends Model
{
    use HasFactory;

    protected $fillable = [
        'ecole_id',
        'nom',
        'prenom', 
        'email',
        'date_naissance',
        'sexe',
        'telephone',
        'numero_rue',
        'nom_rue',
        'ville',
        'province',
        'code_postal',
        'approuve'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'approuve' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relation avec l'école
     */
    public function ecole(): BelongsTo
    {
        return $this->belongsTo(Ecole::class);
    }

    /**
     * Relation avec les ceintures obtenues
     */
    public function ceintures(): BelongsToMany
    {
        return $this->belongsToMany(Ceinture::class, 'ceintures_obtenues')
                    ->withPivot('date_obtention')
                    ->withTimestamps();
    }

    /**
     * Relation avec les cours (inscriptions)
     */
    public function cours(): BelongsToMany
    {
        return $this->belongsToMany(Cours::class, 'inscription_cours')
                    ->withPivot('statut', 'date_inscription', 'montant_paye', 'notes')
                    ->withTimestamps();
    }

    /**
     * Relation avec les présences
     */
    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }

    /**
     * Relation avec les séminaires
     */
    public function seminaires(): BelongsToMany
    {
        return $this->belongsToMany(Seminaire::class, 'membre_seminaire')
                    ->withTimestamps();
    }

    /**
     * Scope pour les membres approuvés
     */
    public function scopeApprouve($query)
    {
        return $query->where('approuve', true);
    }

    /**
     * Scope pour les membres en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('approuve', false);
    }

    /**
     * Scope pour une école spécifique
     */
    public function scopeParEcole($query, $ecoleId)
    {
        return $query->where('ecole_id', $ecoleId);
    }

    /**
     * Accesseur pour le nom complet
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Accesseur pour l'âge
     */
    public function getAgeAttribute(): ?int
    {
        return $this->date_naissance ? $this->date_naissance->age : null;
    }

    /**
     * Obtenir la ceinture actuelle (la plus élevée)
     */
    public function ceintureActuelle()
    {
        return $this->ceintures()->orderBy('niveau', 'desc')->first();
    }

    /**
     * Vérifier si le membre est inscrit à un cours
     */
    public function estInscritAuCours($coursId): bool
    {
        return $this->cours()->where('cours_id', $coursId)->exists();
    }
}
