<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->foreignId('ecole_id')->constrained('ecoles')->onDelete('cascade');
            $table->foreignId('professeur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('capacite_max')->default(20);
            $table->integer('duree_minutes')->default(60);
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'tous'])->default('tous');
            $table->enum('type', ['enfant', 'adulte', 'mixte'])->default('mixte');
            $table->integer('age_min')->nullable();
            $table->integer('age_max')->nullable();
            $table->text('prerequis')->nullable();
            $table->text('tarification_info')->nullable();
            $table->boolean('actif')->default(true);
            $table->timestamps();

            $table->index(['ecole_id', 'actif']);
            $table->index('professeur_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
