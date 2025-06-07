<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('membre_ceinture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained()->onDelete('cascade');
            $table->foreignId('ceinture_id')->constrained()->onDelete('cascade');
            $table->date('date_obtention');
            $table->string('grade_par')->nullable(); // Qui a accordé la ceinture
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['membre_id', 'ceinture_id']);
            $table->index(['membre_id', 'date_obtention']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('membre_ceinture');
    }
};
