<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Les policies seront ajoutées plus tard si nécessaire
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Pour l'instant, on donne accès à tout pour simplifier
        Gate::define('view-any', function ($user, $model) {
            return in_array($user->role, ['superadmin', 'admin']);
        });
    }
}
