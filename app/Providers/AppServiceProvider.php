<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configurer Carbon en français
        Carbon::setLocale('fr_CA');
        setlocale(LC_TIME, 'fr_CA.UTF-8', 'fr_CA', 'fr');

        // Format par défaut pour les dates
        \Illuminate\Support\Facades\Date::macro('toFormattedDateString', function () {
            return $this->format('d/m/Y');
        });
    }
}
