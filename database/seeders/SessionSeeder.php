<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CoursSession;
use App\Models\Ecole;
use Carbon\Carbon;

class SessionSeeder extends Seeder
{
    public function run()
    {
        $annee = Carbon::now()->year;
        $ecoles = Ecole::all();
        
        $sessions = [
            [
                'nom' => 'Hiver ' . $annee,
                'date_debut' => Carbon::create($annee, 1, 15),
                'date_fin' => Carbon::create($annee, 3, 31),
                'couleur' => '#4FC3F7', // Bleu clair
            ],
            [
                'nom' => 'Printemps ' . $annee,
                'date_debut' => Carbon::create($annee, 4, 1),
                'date_fin' => Carbon::create($annee, 6, 15),
                'couleur' => '#81C784', // Vert
            ],
            [
                'nom' => 'Été ' . $annee,
                'date_debut' => Carbon::create($annee, 6, 16),
                'date_fin' => Carbon::create($annee, 8, 31),
                'couleur' => '#FFD54F', // Jaune
            ],
            [
                'nom' => 'Automne ' . $annee,
                'date_debut' => Carbon::create($annee, 9, 1),
                'date_fin' => Carbon::create($annee, 12, 20),
                'couleur' => '#FF8A65', // Orange
            ]
        ];
        
        foreach ($ecoles as $ecole) {
            foreach ($sessions as $session) {
                CoursSession::firstOrCreate([
                    'ecole_id' => $ecole->id,
                    'nom' => $session['nom'],
                ], [
                    'date_debut' => $session['date_debut'],
                    'date_fin' => $session['date_fin'],
                    'couleur' => $session['couleur'],
                    'active' => true,
                    'inscriptions_actives' => true,
                    'visible' => true
                ]);
            }
        }
        
        echo "Sessions créées pour toutes les écoles!\n";
    }
}
