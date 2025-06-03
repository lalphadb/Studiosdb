<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Appeler les seeders individuels
        $this->call([
            RoleSeeder::class,
            CeintureSeeder::class,
            ConsentTypeSeeder::class,
            // SessionSeeder::class, // Commenté car nécessite des écoles
        ]);
    }
}
