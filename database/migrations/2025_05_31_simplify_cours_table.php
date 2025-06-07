<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cours', function (Blueprint $table) {
            // Supprimer les colonnes de prix
            if (Schema::hasColumn('cours', 'prix_enfant')) {
                $table->dropColumn('prix_enfant');
            }
            if (Schema::hasColumn('cours', 'prix_adulte')) {
                $table->dropColumn('prix_adulte');
            }
            if (Schema::hasColumn('cours', 'frequence_semaine')) {
                $table->dropColumn('frequence_semaine');
            }

            // Ajouter le champ tarification libre
            if (! Schema::hasColumn('cours', 'tarification_info')) {
                $table->text('tarification_info')->nullable()->after('places_max');
            }
        });
    }

    public function down()
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->json('prix_enfant')->nullable();
            $table->json('prix_adulte')->nullable();
            $table->integer('frequence_semaine')->default(1);
            $table->dropColumn('tarification_info');
        });
    }
};
