<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('auth_logs', function (Blueprint $table) {
            // Vérifier et ajouter les colonnes manquantes
            if (! Schema::hasColumn('auth_logs', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (! Schema::hasColumn('auth_logs', 'action')) {
                $table->string('action')->after('user_id');
            }
            if (! Schema::hasColumn('auth_logs', 'ip_address')) {
                $table->string('ip_address', 45)->after('action');
            }
            if (! Schema::hasColumn('auth_logs', 'user_agent')) {
                $table->text('user_agent')->after('ip_address');
            }
            if (! Schema::hasColumn('auth_logs', 'url')) {
                $table->text('url')->nullable()->after('user_agent');
            }
            if (! Schema::hasColumn('auth_logs', 'method')) {
                $table->string('method', 10)->nullable()->after('url');
            }
            if (! Schema::hasColumn('auth_logs', 'additional_data')) {
                $table->json('additional_data')->nullable()->after('method');
            }

            // Ajouter les index
            $table->index(['user_id', 'action']);
            $table->index('created_at');
            $table->index('ip_address');
        });
    }

    public function down()
    {
        Schema::table('auth_logs', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'action']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['ip_address']);
        });
    }
};
