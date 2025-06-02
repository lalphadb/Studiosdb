<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auth_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('action'); // login, logout, failed_login, page_access
            $table->string('ip_address');
            $table->text('user_agent');
            $table->text('url')->nullable();
            $table->string('method')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'action']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('auth_logs');
    }
};
