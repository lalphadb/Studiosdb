<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inscriptions_portes_ouvertes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('porte_ouverte_id')->constrained('portes_ouvertes');
            $table->string('prenom');
            $table->string('nom');
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->enum('statut', ['confirmee', 'annulee'])->default('confirmee');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['porte_ouverte_id', 'email']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inscriptions_portes_ouvertes');
    }
};


