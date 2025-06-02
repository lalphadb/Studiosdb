<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inscriptions_cours', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'confirmee', 'annulee'])
                ->default('confirmee')
                ->after('cours_id');
            $table->date('date_inscription')
                ->nullable()
                ->after('statut');
            $table->text('notes')
                ->nullable()
                ->after('date_inscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscriptions_cours', function (Blueprint $table) {
            $table->dropColumn(['statut', 'date_inscription', 'notes']);
        });
    }
};
