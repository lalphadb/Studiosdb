<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Index pour membres
        Schema::table('membres', function (Blueprint $table) {
            if (! Schema::hasIndex('membres', 'membres_ecole_id_index')) {
                $table->index('ecole_id');
            }
            if (! Schema::hasIndex('membres', 'membres_approuve_index')) {
                $table->index('approuve');
            }
        });

        // Index pour cours
        Schema::table('cours', function (Blueprint $table) {
            if (! Schema::hasIndex('cours', 'cours_ecole_id_index')) {
                $table->index('ecole_id');
            }
            if (! Schema::hasIndex('cours', 'cours_session_id_index')) {
                $table->index('session_id');
            }
            if (! Schema::hasIndex('cours', 'cours_actif_index')) {
                $table->index('actif');
            }
        });

        // Index pour activity_log
        Schema::table('activity_log', function (Blueprint $table) {
            if (! Schema::hasIndex('activity_log', 'activity_log_event_index')) {
                $table->index('event');
            }
        });

        // Index pour users
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasIndex('users', 'users_role_index')) {
                $table->index('role');
            }
            if (! Schema::hasIndex('users', 'users_active_index')) {
                $table->index('active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('membres', function (Blueprint $table) {
            $table->dropIndex(['ecole_id']);
            $table->dropIndex(['approuve']);
        });

        Schema::table('cours', function (Blueprint $table) {
            $table->dropIndex(['ecole_id']);
            $table->dropIndex(['session_id']);
            $table->dropIndex(['actif']);
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex(['event']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['active']);
        });
    }
};
