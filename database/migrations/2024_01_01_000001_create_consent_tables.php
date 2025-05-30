<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Types de consentements
        Schema::create('consent_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('version')->default(1);
            $table->timestamps();
        });
        
        // Consentements des utilisateurs
        Schema::create('user_consents', function (Blueprint $table) {
            $table->id();
            $table->morphs('consentable'); // user ou membre
            $table->foreignId('consent_type_id')->constrained();
            $table->boolean('is_granted');
            $table->timestamp('granted_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('source'); // web, api, import, etc.
            $table->integer('version');
            $table->text('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['consentable_type', 'consentable_id']);
            $table->index('consent_type_id');
        });
        
        // Historique des consentements
        Schema::create('consent_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_consent_id')->constrained();
            $table->string('action'); // granted, revoked, updated
            $table->boolean('previous_value')->nullable();
            $table->boolean('new_value');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('consent_history');
        Schema::dropIfExists('user_consents');
        Schema::dropIfExists('consent_types');
    }
};
