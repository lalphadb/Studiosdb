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
        'telephone',
        'email', 
        'responsable',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
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
        return $query->where('active', true);
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
        return $this->cours()->where('statut', 'actif')->count();
    }
}
