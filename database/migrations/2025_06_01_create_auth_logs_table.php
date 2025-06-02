<?php
// database/migrations/2025_06_01_create_auth_logs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('action'); // login_attempt, logout, password_change
            $table->boolean('success')->default(true);
            $table->string('reason')->nullable(); // failed_password, account_locked, etc.
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('created_at');
            
            $table->index(['email', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auth_logs');
    }
};
