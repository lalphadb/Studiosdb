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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define custom gates here if needed
        Gate::define('manage-admin', function ($user) {
            return $user->role === 'superadmin' || $user->role === 'admin';
        });

        Gate::define('manage-ecoles', function ($user) {
            return $user->role === 'superadmin' || $user->role === 'admin';
        });

        Gate::define('manage-membres', function ($user) {
            return $user->role === 'superadmin' || $user->role === 'admin';
        });
    }
}
