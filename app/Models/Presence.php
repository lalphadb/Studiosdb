<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'membre_id',
        'cours_id', 
        'date_presence',
        'status',
        'commentaire',
    ];

    protected $casts = [
        'date_presence' => 'date',
    ];

    // Relations
    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    // Scopes
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeParDate($query, $date)
    {
        return $query->where('date_presence', $date);
    }
}
