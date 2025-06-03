<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ceinture;
use Illuminate\Support\Facades\DB;

class CeintureSeeder extends Seeder
{
    public function run()
    {
        // Désactiver temporairement les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Vider la table
        Ceinture::truncate();
        
        // Réactiver les contraintes
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Créer toutes les ceintures dans le bon ordre
        $ceintures = [
            ['nom' => 'Blanche', 'niveau' => 1, 'ordre' => 1, 'couleur' => '#FFFFFF'],
            ['nom' => 'Jaune', 'niveau' => 2, 'ordre' => 2, 'couleur' => '#FFD700'],
            ['nom' => 'Orange', 'niveau' => 3, 'ordre' => 3, 'couleur' => '#FFA500'],
            ['nom' => 'Violet', 'niveau' => 4, 'ordre' => 4, 'couleur' => '#9400D3'],
            ['nom' => 'Bleue', 'niveau' => 5, 'ordre' => 5, 'couleur' => '#0000FF'],
            ['nom' => 'Bleue I', 'niveau' => 6, 'ordre' => 6, 'couleur' => '#0066FF'],
            ['nom' => 'Verte', 'niveau' => 7, 'ordre' => 7, 'couleur' => '#00FF00'],
            ['nom' => 'Verte I', 'niveau' => 8, 'ordre' => 8, 'couleur' => '#00CC00'],
            ['nom' => 'Brune I', 'niveau' => 9, 'ordre' => 9, 'couleur' => '#8B4513'],
            ['nom' => 'Brune II', 'niveau' => 10, 'ordre' => 10, 'couleur' => '#A0522D'],
            ['nom' => 'Brune III', 'niveau' => 11, 'ordre' => 11, 'couleur' => '#654321'],
            ['nom' => 'Noire (1er Dan) — Shodan', 'niveau' => 12, 'ordre' => 12, 'couleur' => '#000000'],
            ['nom' => 'Noire (2e Dan) — Nidan', 'niveau' => 13, 'ordre' => 13, 'couleur' => '#000000'],
            ['nom' => 'Noire (3e Dan) — Sandan', 'niveau' => 14, 'ordre' => 14, 'couleur' => '#000000'],
            ['nom' => 'Noire (4e Dan) — Yondan', 'niveau' => 15, 'ordre' => 15, 'couleur' => '#000000'],
            ['nom' => 'Noire (5e Dan) — Godan', 'niveau' => 16, 'ordre' => 16, 'couleur' => '#000000'],
            ['nom' => 'Noire (6e Dan) — Rokudan', 'niveau' => 17, 'ordre' => 17, 'couleur' => '#000000'],
            ['nom' => 'Noire (7e Dan) — Nanadan', 'niveau' => 18, 'ordre' => 18, 'couleur' => '#000000'],
            ['nom' => 'Noire (8e Dan) — Hachidan', 'niveau' => 19, 'ordre' => 19, 'couleur' => '#000000'],
            ['nom' => 'Noire (9e Dan) — Kudan', 'niveau' => 20, 'ordre' => 20, 'couleur' => '#000000'],
            ['nom' => 'Noire (10e Dan) — Jūdan', 'niveau' => 21, 'ordre' => 21, 'couleur' => '#000000'],
        ];

        foreach ($ceintures as $ceinture) {
            Ceinture::create($ceinture);
            $this->command->info("Ceinture créée : {$ceinture['nom']}");
        }
        
        $this->command->info('✅ ' . count($ceintures) . ' ceintures créées avec succès!');
    }
}
