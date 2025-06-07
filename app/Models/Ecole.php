<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'statut'
    ];

    protected $casts = [
        'statut' => 'string'
    ];

    // Relations
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function membres()
    {
        return $this->hasMany(Membre::class);
    }

    public function cours()
    {
        return $this->hasMany(Cours::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('statut', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('statut', 'inactive');
    }

    // Helpers
    public function isActive()
    {
        return $this->statut === 'active';
    }
}
