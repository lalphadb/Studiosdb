<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            // Ajouter ecole_id si elle n'existe pas
            if (!Schema::hasColumn('cours', 'ecole_id')) {
                $table->foreignId('ecole_id')->nullable()->constrained('ecoles')->onDelete('cascade');
            }
            
            // Ajouter session_id si elle n'existe pas
            if (!Schema::hasColumn('cours', 'session_id')) {
                $table->foreignId('session_id')->nullable()->constrained('cours_sessions')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            if (Schema::hasColumn('cours', 'session_id')) {
                $table->dropForeign(['session_id']);
                $table->dropColumn('session_id');
            }
        });
    }
};
