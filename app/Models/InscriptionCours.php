<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionCours extends Model
{
    use HasFactory;

    protected $table = 'inscriptions_cours';

    protected $fillable = [
        'membre_id',
        'cours_id',
        'date_inscription',
        'statut',
        'notes'
    ];

    protected $casts = [
        'date_inscription' => 'datetime',
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
}
