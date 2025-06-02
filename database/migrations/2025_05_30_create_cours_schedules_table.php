<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table pour les horaires récurrents
        Schema::create('cours_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained()->onDelete('cascade');
            $table->enum('jour_semaine', ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('capacite_max')->default(20);
            $table->string('salle')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            $table->index(['cours_id', 'jour_semaine']);
        });
        
        // Ajouter le type de cours dans la table cours si pas présent
        Schema::table('cours', function (Blueprint $table) {
            if (!Schema::hasColumn('cours', 'type_cours')) {
                $table->enum('type_cours', ['regulier', 'parent_enfant', 'ceinture_avancee', 'competition', 'prive'])->default('regulier')->after('description');
            }
            if (!Schema::hasColumn('cours', 'age_min')) {
                $table->integer('age_min')->nullable()->after('type_cours');
            }
            if (!Schema::hasColumn('cours', 'age_max')) {
                $table->integer('age_max')->nullable()->after('age_min');
            }
            if (!Schema::hasColumn('cours', 'ceinture_requise_id')) {
                $table->foreignId('ceinture_requise_id')->nullable()->constrained('ceintures')->after('age_max');
            }
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('cours_schedules');
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['type_cours', 'age_min', 'age_max', 'ceinture_requise_id']);
        });
    }
};
