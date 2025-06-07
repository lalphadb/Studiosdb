<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seminaire extends Model
{
    use HasFactory;

    protected $table = 'seminaires';

    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function membres()
    {
        return $this->belongsToMany(Membre::class, 'membre_seminaire')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('date_debut');
    }

    public function scopeFuture($query)
    {
        return $query->where('date_debut', '>', now());
    }
}
