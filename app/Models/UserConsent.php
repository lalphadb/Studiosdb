<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserConsent extends Model
{
    protected $fillable = [
        'consent_type_id', 'is_granted', 'granted_at', 'revoked_at',
        'ip_address', 'user_agent', 'source', 'version', 'metadata'
    ];
    
    protected $casts = [
        'is_granted' => 'boolean',
        'granted_at' => 'datetime',
        'revoked_at' => 'datetime',
        'metadata' => 'array'
    ];
    
    public function consentable()
    {
        return $this->morphTo();
    }
    
    public function consentType()
    {
        return $this->belongsTo(ConsentType::class);
    }
}
