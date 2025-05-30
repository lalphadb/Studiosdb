<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function ceintures()
    {
        return $this->belongsToMany(Ceinture::class, 'ceintures_membres')
                    ->withPivot('date_obtention')
                    ->withTimestamps();
    }

    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getAgeAttribute()
    {
        return $this->date_naissance ? Carbon::parse($this->date_naissance)->age : null;
    }
}
