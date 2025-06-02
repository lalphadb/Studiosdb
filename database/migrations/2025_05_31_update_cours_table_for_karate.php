<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cours', function (Blueprint $table) {
            // Ajouter les colonnes de prix
            $table->json('prix_enfant')->nullable()->after('tarif')->comment('Prix pour enfants: {1: prix_1x, 2: prix_2x, 3: prix_3x}');
            $table->json('prix_adulte')->nullable()->after('prix_enfant')->comment('Prix pour adultes: {1: prix_1x, 2: prix_2x, 3: prix_3x}');
            $table->integer('frequence_semaine')->default(1)->after('prix_adulte')->comment('Nombre de fois par semaine');
            
            // Simplifier le statut
            if (Schema::hasColumn('cours', 'statut')) {
                $table->dropColumn('statut');
            }
            $table->boolean('actif')->default(true)->after('frequence_semaine');
            
            // Supprimer les colonnes non nécessaires
            if (Schema::hasColumn('cours', 'niveau')) {
                $table->dropColumn('niveau');
            }
            if (Schema::hasColumn('cours', 'niveau_requis')) {
                $table->dropColumn('niveau_requis');
            }
            if (Schema::hasColumn('cours', 'instructeur')) {
                $table->dropColumn('instructeur');
            }
            if (Schema::hasColumn('cours', 'duree_minutes')) {
                $table->dropColumn('duree_minutes');
            }
        });
    }

    public function down()
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['prix_enfant', 'prix_adulte', 'frequence_semaine', 'actif']);
            $table->enum('statut', ['actif', 'inactif', 'complet', 'annule'])->default('actif');
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'tous_niveaux'])->nullable();
            $table->string('niveau_requis')->nullable();
            $table->string('instructeur')->nullable();
            $table->integer('duree_minutes')->nullable();
        });
    }
};
