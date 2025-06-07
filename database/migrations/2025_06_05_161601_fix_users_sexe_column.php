<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier la colonne sexe pour accepter les valeurs françaises
        DB::statement("ALTER TABLE users MODIFY sexe ENUM('M', 'F', 'Masculin', 'Féminin', 'Homme', 'Femme') NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY sexe VARCHAR(20) NULL");
    }
};
