<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionCours extends Model
{
    use HasFactory;

    protected $table = 'inscription_cours';

    protected $fillable = [
        'membre_id',
        'cours_id',
        'session_id',
        'statut',
        'raison_changement',
        'date_inscription',
        'montant_paye',
        'notes',
    ];

    protected $casts = [
        'date_inscription' => 'date',
        'montant_paye' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Une inscription appartient à un membre
     */
    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    /**
     * Une inscription appartient à un cours
     */
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    /**
     * Une inscription peut appartenir à une session
     */
    public function session()
    {
        return $this->belongsTo(CoursSession::class, 'session_id');
    }

    /**
     * Scope pour les inscriptions confirmées
     */
    public function scopeConfirmees($query)
    {
        return $query->where('statut', 'confirmee');
    }

    /**
     * Scope pour les inscriptions en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }
}
