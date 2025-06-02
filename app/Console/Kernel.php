<?php
// app/Console/Kernel.php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Nettoyer les activity logs tous les jours à 2h du matin
        $schedule->command('activitylog:clean')->daily()->at('02:00');
        
        // Nettoyer les sessions expirées
        $schedule->call(function () {
            \DB::table('sessions')
                ->where('last_activity', '<', now()->subHours(24)->timestamp)
                ->delete();
        })->daily();
        
        // Backup quotidien
        $schedule->exec('bash ' . base_path('maintenance.sh'))
            ->daily()
            ->at('03:00')
            ->appendOutputTo(storage_path('logs/maintenance.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
