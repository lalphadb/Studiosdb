<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $table = 'presences';

    protected $fillable = [
        'membre_id',
        'cours_id',
        'date_presence',
        'status',
        'commentaire',
    ];

    protected $casts = [
        'date_presence' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function scopeCeMois($query)
    {
        return $query->whereMonth('date_presence', now()->month)
                    ->whereYear('date_presence', now()->year);
    }

    public function scopePresents($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsents($query)
    {
        return $query->where('status', 'absent');
    }
}
