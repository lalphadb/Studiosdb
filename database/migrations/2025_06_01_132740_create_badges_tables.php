<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table des badges
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('description');
            $table->string('icone'); // Ex: 'bi-trophy-fill'
            $table->string('type'); // 'presence', 'progression', 'social', 'special'
            $table->integer('points')->default(0);
            $table->json('conditions'); // Conditions pour obtenir le badge
            $table->string('couleur')->default('#00d4ff');
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });

        // Table pivot membre_badges
        Schema::create('membre_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained()->onDelete('cascade');
            $table->timestamp('obtenu_le');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Un membre ne peut avoir le même badge qu'une fois
            $table->unique(['membre_id', 'badge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membre_badges');
        Schema::dropIfExists('badges');
    }
};
