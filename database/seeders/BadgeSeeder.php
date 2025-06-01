<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'nom' => 'Première Ceinture',
                'description' => 'Obtenir sa première ceinture',
                'icone' => 'bi-award-fill',
                'type' => 'progression',
                'points' => 100,
                'conditions' => ['ceinture_niveau' => 1],
                'couleur' => '#00d4ff'
            ],
            [
                'nom' => 'En Feu',
                'description' => '30 jours de présence consécutive',
                'icone' => 'bi-fire',
                'type' => 'presence',
                'points' => 500,
                'conditions' => ['jours_consecutifs' => 30],
                'couleur' => '#ff6b00'
            ],
            [
                'nom' => 'Étoile Montante',
                'description' => 'Progression rapide (3 ceintures en 6 mois)',
                'icone' => 'bi-star-fill',
                'type' => 'progression',
                'points' => 750,
                'conditions' => ['ceintures_6mois' => 3],
                'couleur' => '#ffaa00'
            ],
            [
                'nom' => 'Maître',
                'description' => 'Obtenir la ceinture noire',
                'icone' => 'bi-trophy-fill',
                'type' => 'progression',
                'points' => 2000,
                'conditions' => ['ceinture_niveau' => 10],
                'couleur' => '#ff0080'
            ],
            [
                'nom' => 'Ambassadeur',
                'description' => 'Parrainer 5 nouveaux membres',
                'icone' => 'bi-people-fill',
                'type' => 'social',
                'points' => 1000,
                'conditions' => ['parrainages' => 5],
                'couleur' => '#7928ca'
            ],
            [
                'nom' => 'Perfectionniste',
                'description' => '100% de présence sur une session',
                'icone' => 'bi-check-circle-fill',
                'type' => 'presence',
                'points' => 300,
                'conditions' => ['presence_session' => 100],
                'couleur' => '#00ff88'
            ]
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
