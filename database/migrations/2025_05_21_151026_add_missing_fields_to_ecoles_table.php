<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ecoles', function (Blueprint $table) {
            // Ajouter adresse si elle n'existe pas
            if (! Schema::hasColumn('ecoles', 'adresse')) {
                $table->string('adresse')->nullable();
            }

            // Ajouter ville si elle n'existe pas
            if (! Schema::hasColumn('ecoles', 'ville')) {
                $table->string('ville')->nullable();
            }

            // Ajouter province si elle n'existe pas
            if (! Schema::hasColumn('ecoles', 'province')) {
                $table->string('province')->default('Québec')->nullable();
            }

            // Ajouter code_postal si il n'existe pas
            if (! Schema::hasColumn('ecoles', 'code_postal')) {
                $table->string('code_postal', 10)->nullable();
            }

            // Ajouter telephone si il n'existe pas
            if (! Schema::hasColumn('ecoles', 'telephone')) {
                $table->string('telephone', 20)->nullable();
            }

            // Ajouter email si il n'existe pas
            if (! Schema::hasColumn('ecoles', 'email')) {
                $table->string('email')->nullable();
            }

            // Ajouter statut si il n'existe pas
            if (! Schema::hasColumn('ecoles', 'statut')) {
                $table->enum('statut', ['active', 'inactive'])->default('active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ecoles', function (Blueprint $table) {
            $columns = ['adresse', 'ville', 'province', 'code_postal', 'telephone', 'email', 'statut'];

            foreach ($columns as $column) {
                if (Schema::hasColumn('ecoles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
