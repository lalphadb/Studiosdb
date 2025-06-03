<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'approuve',
        'niveau_ceinture',
        'date_derniere_ceinture',
        'photo',
        'ceinture_id'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_derniere_ceinture' => 'date',
        'approuve' => 'boolean',
    ];

    // Relations
    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function ceintures()
    {
        return $this->belongsToMany(Ceinture::class, 'membre_ceinture')
                    ->withPivot('date_obtention', 'grade_par', 'notes')
                    ->withTimestamps();
    }

    public function seminaires()
    {
        return $this->belongsToMany(Seminaire::class, 'membre_seminaire')
                    ->withTimestamps();
    }

    public function cours()
    {
        return $this->belongsToMany(Cours::class, 'inscriptions_cours')
                    ->withPivot('statut', 'date_inscription', 'notes')
                    ->withTimestamps();
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    // Accesseurs
    public function getAgeAttribute()
    {
        return $this->date_naissance ? $this->date_naissance->age : null;
    }

    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
