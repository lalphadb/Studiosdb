<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cours', function (Blueprint $table) {
            // Ajouter le type de cours
            if (!Schema::hasColumn('cours', 'type_cours')) {
                $table->enum('type_cours', ['regulier', 'parent_enfant', 'ceinture_avancee', 'competition', 'prive'])
                    ->default('regulier')
                    ->after('nom');
            }
            
            // Ajouter les champs d'âge
            if (!Schema::hasColumn('cours', 'age_min')) {
                $table->integer('age_min')->nullable()->after('niveau');
            }
            if (!Schema::hasColumn('cours', 'age_max')) {
                $table->integer('age_max')->nullable()->after('age_min');
            }
            
            // Ajouter la ceinture requise
            if (!Schema::hasColumn('cours', 'ceinture_requise_id')) {
                $table->foreignId('ceinture_requise_id')
                    ->nullable()
                    ->constrained('ceintures')
                    ->nullOnDelete()
                    ->after('age_max');
            }
            
            // Ajouter la durée en minutes
            if (!Schema::hasColumn('cours', 'duree')) {
                $table->integer('duree')->default(60)->after('tarif');
            }
        });
    }
    
    public function down()
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['type_cours', 'age_min', 'age_max', 'duree']);
            $table->dropForeign(['ceinture_requise_id']);
            $table->dropColumn('ceinture_requise_id');
        });
    }
};
