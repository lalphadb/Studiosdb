<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pour MySQL - Modifier la colonne avec la syntaxe correcte
        DB::statement('ALTER TABLE membres MODIFY COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE membres MODIFY COLUMN id INT UNSIGNED NOT NULL AUTO_INCREMENT');
    }
};
