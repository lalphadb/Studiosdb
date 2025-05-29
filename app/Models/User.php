<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'prenom',
        'nom', 
        'date_naissance',
        'sexe',
        'telephone',
        'numero_civique',
        'nom_rue',
        'ville',
        'province',
        'code_postal',
        'ecole_id',
        'membre_id',
        'name',
        'email',
        'username',
        'role',
        'password',
        'active',
        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',
        'theme_preference',
        'language_preference',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'locked_until' => 'datetime',
    ];

    // Relations
    public function ecole()
    {
        return $this->belongsTo(\App\Models\Ecole::class);
    }

    public function membre()
    {
        return $this->belongsTo(\App\Models\Membre::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return trim(($this->prenom ?? '') . ' ' . ($this->nom ?? '')) ?: $this->name;
    }

    public function getIsLockedAttribute()
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    public function getLastLoginHumanAttribute()
    {
        return $this->last_login_at ? $this->last_login_at->diffForHumans() : 'Jamais connecté';
    }

    public function getRoleDisplayAttribute()
    {
        return match($this->role) {
            'superadmin' => 'Super Administrateur',
            'admin' => 'Administrateur',
            'instructeur' => 'Instructeur',
            'membre' => 'Membre',
            default => ucfirst($this->role)
        };
    }

    // Méthodes de sécurité
    public function incrementLoginAttempts()
    {
        $this->increment('login_attempts');
        
        // Verrouiller après 5 tentatives
        if ($this->login_attempts >= 5) {
            $this->update(['locked_until' => now()->addMinutes(15)]);
        }
    }

    public function resetLoginAttempts()
    {
        $this->update([
            'login_attempts' => 0,
            'locked_until' => null,
        ]);
    }

    public function updateLoginInfo($request)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);
    }
}
