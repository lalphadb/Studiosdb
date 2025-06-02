<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portes_ouvertes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ecole_id')->constrained();
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('places_max')->default(30);
            $table->boolean('active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('portes_ouvertes');
    }
};
