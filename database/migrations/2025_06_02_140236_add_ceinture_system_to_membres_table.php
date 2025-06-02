<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('membres', function (Blueprint $table) {
            $table->enum('niveau_ceinture', [
                'blanche', 'jaune', 'orange', 'verte', 
                'bleue', 'marron', 'noire'
            ])->default('blanche')->after('approuve');
            
            $table->date('date_derniere_ceinture')->nullable()->after('niveau_ceinture');
        });
    }

    public function down()
    {
        Schema::table('membres', function (Blueprint $table) {
            $table->dropColumn(['niveau_ceinture', 'date_derniere_ceinture']);
        });
    }
};
