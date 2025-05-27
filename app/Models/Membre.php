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
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'approuve' => 'boolean',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function inscriptionsCours()
    {
        return $this->hasMany(InscriptionCours::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function ceintures()
    {
        return $this->belongsToMany(Ceinture::class, 'ceintures_obtenues')
                    ->withPivot('date_obtention')
                    ->withTimestamps();
    }

    public function scopeApprouve($query)
    {
        return $query->where('approuve', true);
    }

    public function scopeEnAttente($query)
    {
        return $query->where('approuve', false);
    }

    public function getFullNameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getAgeAttribute()
    {
        return $this->date_naissance ? $this->date_naissance->age : null;
    }
}
