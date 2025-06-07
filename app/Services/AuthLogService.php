<?php

// app/Services/AuthLogService.php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AuthLogService
{
    /**
     * Journaliser une tentative de connexion
     */
    public function logLoginAttempt(string $email, bool $success, ?string $reason = null): void
    {
        DB::table('auth_logs')->insert([
            'email' => $email,
            'action' => 'login_attempt',
            'success' => $success,
            'reason' => $reason,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'created_at' => Carbon::now(),
        ]);
    }

    /**
     * Journaliser une déconnexion
     */
    public function logLogout(User $user): void
    {
        activity()
            ->causedBy($user)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_duration' => $this->calculateSessionDuration($user),
            ])
            ->log('Déconnexion');
    }

    /**
     * Journaliser un changement de mot de passe
     */
    public function logPasswordChange(User $user): void
    {
        activity()
            ->causedBy($user)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log('Changement de mot de passe');
    }

    /**
     * Obtenir l'historique des connexions d'un utilisateur
     */
    public function getUserLoginHistory(User $user, int $limit = 10)
    {
        return DB::table('auth_logs')
            ->where('email', $user->email)
            ->where('action', 'login_attempt')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Calculer la durée de session
     */
    private function calculateSessionDuration(User $user): int
    {
        if (! $user->last_login_at) {
            return 0;
        }

        return Carbon::parse($user->last_login_at)->diffInMinutes(Carbon::now());
    }

    /**
     * Nettoyer les logs anciens (RGPD)
     */
    public function cleanOldLogs(int $daysToKeep = 365): int
    {
        return DB::table('auth_logs')
            ->where('created_at', '<', Carbon::now()->subDays($daysToKeep))
            ->delete();
    }
}
