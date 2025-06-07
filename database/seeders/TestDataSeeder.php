<?php

namespace Database\Seeders;

use App\Models\Cours;
use App\Models\CoursSession;
use App\Models\Membre;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Créer 50 membres pour l'école de Louis (ID=17)
        $membres = [];
        for ($i = 1; $i <= 50; $i++) {
            $membres[] = Membre::create([
                'ecole_id' => 17,
                'nom' => 'Membre'.$i,
                'prenom' => 'Test'.$i,
                'email' => "membre{$i}@test.com",
                'date_naissance' => Carbon::now()->subYears(rand(8, 45)),
                'sexe' => rand(0, 1) ? 'H' : 'F',
                'telephone' => '418-555-'.str_pad($i, 4, '0', STR_PAD_LEFT),
                'ville' => 'Québec',
                'province' => 'QC',
                'approuve' => $i <= 45, // 45 approuvés, 5 en attente
                'niveau_ceinture' => ['blanche', 'jaune', 'orange', 'verte', 'bleue'][rand(0, 4)],
                'created_at' => Carbon::now()->subDays(rand(1, 365)),
            ]);
        }

        // Créer 10 cours pour l'école de Louis
        for ($i = 1; $i <= 10; $i++) {
            Cours::create([
                'nom' => 'Karaté Niveau '.$i,
                'description' => 'Cours de karaté niveau débutant/intermédiaire',
                'type_cours' => ['regulier', 'parent_enfant', 'ceinture_avancee'][rand(0, 2)],
                'ecole_id' => 17,
                'capacite_max' => rand(15, 30),
                'duree_minutes' => [60, 90, 120][rand(0, 2)],
                'type' => ['enfant', 'adulte', 'mixte'][rand(0, 2)],
                'actif' => true,
            ]);
        }

        // Créer des sessions cette semaine
        $cours = Cours::where('ecole_id', 17)->get();
        foreach ($cours as $c) {
            for ($day = 0; $day < 7; $day++) {
                CoursSession::create([
                    'cours_id' => $c->id,
                    'date_debut' => Carbon::now()->addDays($day)->setTime(rand(9, 20), 0),
                    'date_fin' => Carbon::now()->addDays($day)->setTime(rand(9, 20), 0)->addMinutes($c->duree_minutes),
                    'ecole_id' => 17,
                ]);
            }
        }

        echo "✅ 50 membres, 10 cours et sessions créés pour l'école St-Émile\n";
    }
}
