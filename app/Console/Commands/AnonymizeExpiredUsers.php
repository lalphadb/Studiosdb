<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AnonymizeExpiredUsers extends Command
{
    protected $signature = 'gdpr:anonymize-expired {--days=2555}';

    protected $description = 'Anonymise les utilisateurs supprimés depuis X jours';

    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $users = User::onlyTrashed()
            ->where('deleted_at', '<', $cutoffDate)
            ->get();

        $count = 0;
        foreach ($users as $user) {
            $user->anonymize();
            $count++;
        }

        $this->info("$count utilisateurs anonymisés avec succès.");

        return Command::SUCCESS;
    }
}
