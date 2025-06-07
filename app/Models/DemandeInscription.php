<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeInscription extends Model
{
    use HasFactory;

    // IMPORTANT: Spécifier explicitement le nom de la table
    protected $table = 'demandes_inscriptions';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'ecole_id',
        'message',
        'statut',
    ];

    public function ecole()
    {
        return $this->belongsTo(Ecole::class);
    }
}
