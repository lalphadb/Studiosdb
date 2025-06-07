<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity, SoftDeletes;

    protected $fillable = [
        'prenom',
        'nom',
        'name',
        'email',
        'username',
        'password',
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
        'role',
        'active',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',
        'theme_preference',
        'language_preference'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'active' => 'boolean',
            'date_naissance' => 'date',
        ];
    }

    // Relations
    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    // Activity Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'role', 'active'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Helper methods
    public function isActive(): bool
    {
        return $this->active;
    }

    public function isBlocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }
}
