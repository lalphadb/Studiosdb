<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ecole extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'adresse',
        'ville',
        'province',
        'code_postal',
        'telephone',
        'email', 
        'responsable',
        'statut'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relation avec les membres
     */
    public function membres(): HasMany
    {
        return $this->hasMany(Membre::class);
    }

    /**
     * Relation avec les cours
     */
    public function cours(): HasMany
    {
        return $this->hasMany(Cours::class);
    }

    /**
     * Relation avec les sessions
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(CoursSession::class);
    }

    /**
     * Relation avec les utilisateurs (admins d'école)
     */
    public function utilisateurs(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Scope pour les écoles actives
     */
    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    /**
     * Accesseur pour l'adresse complète
     */
    public function getAdresseCompleteAttribute(): string
    {
        $parts = array_filter([
            $this->adresse,
            $this->ville,
            $this->province,
            $this->code_postal
        ]);
        
        return implode(', ', $parts);
    }

    /**
     * Vérifier si les informations sont complètes
     */
    public function getIsCompleteAttribute(): bool
    {
        return !empty($this->adresse) 
            && !empty($this->telephone) 
            && !empty($this->email)
            && !empty($this->responsable);
    }

    /**
     * Obtenir le nombre de membres
     */
    public function getNombreMembresAttribute(): int
    {
        return $this->membres()->count();
    }

    /**
     * Obtenir le nombre de membres approuvés
     */
    public function getNombreMembresApprouvesAttribute(): int
    {
        return $this->membres()->where('approuve', true)->count();
    }

    /**
     * Obtenir le nombre de cours actifs
     */
    public function getNombreCoursActifsAttribute(): int
    {
        return $this->cours()->where('actif', true)->count();
    }
}
