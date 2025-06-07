<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'icone',
        'type',
        'points',
        'conditions',
        'couleur',
        'actif',
    ];

    protected $casts = [
        'conditions' => 'array',
        'actif' => 'boolean',
    ];

    public function membres()
    {
        return $this->belongsToMany(Membre::class, 'membre_badges')
            ->withPivot('obtenu_le', 'notes')
            ->withTimestamps();
    }

    // Vérifier si un membre mérite ce badge
    public function checkCondition(Membre $membre): bool
    {
        switch ($this->type) {
            case 'presence':
                return $this->checkPresenceCondition($membre);
            case 'progression':
                return $this->checkProgressionCondition($membre);
            case 'social':
                return $this->checkSocialCondition($membre);
            default:
                return false;
        }
    }

    private function checkPresenceCondition(Membre $membre): bool
    {
        $conditions = $this->conditions;

        if (isset($conditions['jours_consecutifs'])) {
            // Vérifier les présences consécutives
            $presencesConsecutives = $membre->presences()
                ->orderBy('date', 'desc')
                ->take($conditions['jours_consecutifs'])
                ->count();

            return $presencesConsecutives >= $conditions['jours_consecutifs'];
        }

        return false;
    }

    private function checkProgressionCondition(Membre $membre): bool
    {
        $conditions = $this->conditions;

        if (isset($conditions['ceinture_niveau'])) {
            return $membre->ceinture_actuelle >= $conditions['ceinture_niveau'];
        }

        return false;
    }

    private function checkSocialCondition(Membre $membre): bool
    {
        // Logique pour les badges sociaux
        return false;
    }
}
