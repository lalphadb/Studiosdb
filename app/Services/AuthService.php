<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class AuthService
{
    /**
     * Journaliser une connexion réussie
     */
    public function logSuccessfulLogin(User $user): void
    {
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('auth.login')
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'ecole_id' => $user->ecole_id,
                'role' => $user->role,
                'login_at' => now()->toDateTimeString()
            ])
            ->log('Connexion réussie');

        // Log système additionnel
        Log::channel('daily')->info('User login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ecole_id' => $user->ecole_id
        ]);
    }

    /**
     * Journaliser une déconnexion
     */
    public function logLogout(User $user): void
    {
        $sessionDuration = $user->last_login_at 
            ? Carbon::parse($user->last_login_at)->diffInMinutes(now()) 
            : 0;

        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('auth.logout')
            ->withProperties([
                'ip' => request()->ip(),
                'session_duration_minutes' => $sessionDuration,
                'logout_at' => now()->toDateTimeString()
            ])
            ->log('Déconnexion');
    }

    /**
     * Journaliser une tentative de connexion échouée
     */
    public function logFailedLogin(string $email, string $reason = 'invalid_credentials'): void
    {
        $user = User::where('email', $email)->first();

        activity()
            ->causedBy($user)
            ->event('auth.failed')
            ->withProperties([
                'email' => $email,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'reason' => $reason,
                'failed_at' => now()->toDateTimeString()
            ])
            ->log('Tentative de connexion échouée');
    }

    /**
     * Journaliser un compte verrouillé
     */
    public function logAccountLocked(User $user, int $minutes): void
    {
        activity()
            ->causedBy($user)
            ->performedOn($user)
            ->event('auth.locked')
            ->withProperties([
                'ip' => request()->ip(),
                'locked_for_minutes' => $minutes,
                'locked_until' => now()->addMinutes($minutes)->toDateTimeString()
            ])
            ->log('Compte verrouillé');
    }

    /**
     * Obtenir l'historique de connexion d'un utilisateur
     */
    public function getUserLoginHistory(int $userId, int $limit = 20)
    {
        return Activity::where('causer_id', $userId)
            ->where('causer_type', User::class)
            ->whereIn('event', ['auth.login', 'auth.logout', 'auth.failed'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($activity) {
                return [
                    'action' => $this->getActionLabel($activity->event),
                    'ip' => $activity->properties['ip'] ?? 'N/A',
                    'date' => $activity->created_at->format('d/m/Y H:i:s'),
                    'duration' => $activity->properties['session_duration_minutes'] ?? null,
                    'status' => $this->getStatusFromEvent($activity->event)
                ];
            });
    }

    /**
     * Obtenir les statistiques de connexion
     */
    public function getLoginStats(int $days = 30)
    {
        $startDate = now()->subDays($days);
        
        return [
            'total_logins' => Activity::where('event', 'auth.login')
                ->where('created_at', '>=', $startDate)
                ->count(),
            
            'failed_attempts' => Activity::where('event', 'auth.failed')
                ->where('created_at', '>=', $startDate)
                ->count(),
            
            'unique_users' => Activity::where('event', 'auth.login')
                ->where('created_at', '>=', $startDate)
                ->distinct('causer_id')
                ->count('causer_id'),
            
            'locked_accounts' => Activity::where('event', 'auth.locked')
                ->where('created_at', '>=', $startDate)
                ->count()
        ];
    }

    /**
     * Obtenir les activités suspectes
     */
    public function getSuspiciousActivities(int $hours = 24)
    {
        $threshold = 5; // Nombre de tentatives échouées considéré comme suspect
        
        return Activity::where('event', 'auth.failed')
            ->where('created_at', '>=', now()->subHours($hours))
            ->get()
            ->groupBy('properties.ip')
            ->filter(function ($group) use ($threshold) {
                return $group->count() >= $threshold;
            })
            ->map(function ($group) {
                return [
                    'ip' => $group->first()->properties['ip'],
                    'attempts' => $group->count(),
                    'emails' => $group->pluck('properties.email')->unique()->values(),
                    'last_attempt' => $group->last()->created_at->format('d/m/Y H:i:s')
                ];
            });
    }

    /**
     * Nettoyer les logs anciens (RGPD/Loi 25)
     */
    public function cleanOldLogs(int $daysToKeep = 365): int
    {
        return Activity::whereIn('event', ['auth.login', 'auth.logout', 'auth.failed', 'auth.locked'])
            ->where('created_at', '<', now()->subDays($daysToKeep))
            ->delete();
    }

    /**
     * Déterminer la route de redirection selon le rôle
     */
    public function getRedirectRoute(User $user): string
    {
        return match($user->role) {
            'superadmin' => route('admin.dashboard'),
            'admin' => route('admin.dashboard'),
            'membre' => route('membre.dashboard'),
            default => route('home')
        };
    }

    /**
     * Obtenir toutes les activités d'authentification pour l'admin
     */
    public function getAllAuthActivities($filters = [], $perPage = 20)
    {
        $query = Activity::whereIn('event', ['auth.login', 'auth.logout', 'auth.failed', 'auth.locked']);

        // Appliquer les filtres
        if (!empty($filters['user_id'])) {
            $query->where('causer_id', $filters['user_id']);
        }

        if (!empty($filters['event'])) {
            $query->where('event', $filters['event']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['ip'])) {
            $query->where('properties->ip', $filters['ip']);
        }

        return $query->with('causer')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Exporter les logs d'authentification (Loi 25)
     */
    public function exportAuthLogs($userId = null, $format = 'csv')
    {
        $query = Activity::whereIn('event', ['auth.login', 'auth.logout', 'auth.failed', 'auth.locked']);
        
        if ($userId) {
            $query->where('causer_id', $userId);
        }
        
        $data = $query->get()->map(function ($activity) {
            return [
                'Date' => $activity->created_at->format('d/m/Y H:i:s'),
                'Utilisateur' => $activity->causer->name ?? 'N/A',
                'Email' => $activity->causer->email ?? $activity->properties['email'] ?? 'N/A',
                'Action' => $this->getActionLabel($activity->event),
                'IP' => $activity->properties['ip'] ?? 'N/A',
                'Durée session (min)' => $activity->properties['session_duration_minutes'] ?? 'N/A'
            ];
        });

        return $data;
    }

    /**
     * Vérifier si une IP est bloquée
     */
    public function isIpBlocked(string $ip): bool
    {
        $recentFailures = Activity::where('event', 'auth.failed')
            ->where('properties->ip', $ip)
            ->where('created_at', '>=', now()->subHours(1))
            ->count();

        return $recentFailures >= 10; // Bloquer après 10 tentatives en 1 heure
    }

    /**
     * Obtenir le résumé d'activité pour le dashboard
     */
    public function getDashboardSummary()
    {
        $today = now()->startOfDay();
        
        return [
            'connexions_aujourd_hui' => Activity::where('event', 'auth.login')
                ->where('created_at', '>=', $today)
                ->count(),
                
            'utilisateurs_actifs' => Activity::where('event', 'auth.login')
                ->where('created_at', '>=', $today)
                ->distinct('causer_id')
                ->count('causer_id'),
                
            'tentatives_echouees' => Activity::where('event', 'auth.failed')
                ->where('created_at', '>=', $today)
                ->count(),
                
            'comptes_verrouilles' => User::where('locked_until', '>', now())->count()
        ];
    }

    /**
     * Helpers privés
     */
    private function getActionLabel(?string $event): string
    {
        return match($event) {
            'auth.login' => 'Connexion',
            'auth.logout' => 'Déconnexion',
            'auth.failed' => 'Tentative échouée',
            'auth.locked' => 'Compte verrouillé',
            default => 'Action inconnue'
        };
    }

    private function getStatusFromEvent(?string $event): string
    {
        return match($event) {
            'auth.login' => 'success',
            'auth.logout' => 'info',
            'auth.failed' => 'danger',
            'auth.locked' => 'warning',
            default => 'secondary'
        };
    }
}
