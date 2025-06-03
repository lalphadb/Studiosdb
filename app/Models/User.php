<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
        'prenom',
        'nom',
        'ecole_id',
        'active',
        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',  // IMPORTANT : Ajouter cette ligne
        'locked_until' => 'datetime',   // IMPORTANT : Ajouter cette ligne
        'active' => 'boolean',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['admin', 'superadmin']);
    }
}
