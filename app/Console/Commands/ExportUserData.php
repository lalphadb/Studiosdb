<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportUserData extends Command
{
    protected $signature = 'gdpr:export-user {user_id}';

    protected $description = 'Exporte toutes les données d\'un utilisateur';

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::findOrFail($userId);

        $data = $user->exportPersonalData();
        $filename = "export_utilisateur_{$userId}_".now()->format('Y-m-d_H-i-s').'.json';

        Storage::disk('local')->put("gdpr_exports/{$filename}", json_encode($data, JSON_PRETTY_PRINT));

        $this->info("Données exportées dans storage/app/gdpr_exports/{$filename}");

        return Command::SUCCESS;
    }
}
