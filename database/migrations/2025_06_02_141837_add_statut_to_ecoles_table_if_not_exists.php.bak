<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('ecoles', 'statut')) {
            Schema::table('ecoles', function (Blueprint $table) {
                $table->enum('statut', ['actif', 'inactif'])->default('actif')->after('email');
            });
        }
        
        if (!Schema::hasColumn('sessions', 'statut')) {
            Schema::table('sessions', function (Blueprint $table) {
                $table->enum('statut', ['actif', 'inactif', 'terminé'])->default('actif')->after('places_max');
            });
        }
    }

    public function down()
    {
        // On ne supprime pas les colonnes en cas de rollback pour éviter la perte de données
    }
};
