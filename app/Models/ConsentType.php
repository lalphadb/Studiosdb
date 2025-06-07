<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsentType extends Model
{
    protected $fillable = [
        'key', 'name', 'description', 'is_required', 'is_active', 'version',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function userConsents()
    {
        return $this->hasMany(UserConsent::class);
    }
}
