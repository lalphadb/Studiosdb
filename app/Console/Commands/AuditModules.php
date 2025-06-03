<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AuditModules extends Command
{
    protected $signature = 'studiosdb:audit';
    protected $description = 'Audite tous les modules Blade et détecte les incohérences de layout/couleur';

    public function handle()
    {
        $bladeFiles = File::allFiles(resource_path('views'));

        $this->info("🧪 Audit visuel des fichiers Blade...");
        $count = 0;

        foreach ($bladeFiles as $file) {
            $content = file_get_contents($file->getRealPath());

            $layout = preg_match('/@extends\(.*layouts\/(.*?)\.blade\.php.*\)/', $content, $matches)
                ? $matches[1]
                : '❌ Aucun layout détecté';

            $themeClass = preg_match('/class=".*?(dark|glass|theme-[a-z0-9\-]+).*?"/', $content, $themeMatches)
                ? $themeMatches[1]
                : '❌ Pas de thème trouvé';

            $this->line("🗂️ " . $file->getFilename() . " → Layout : {$layout} | Thème : {$themeClass}");

            $count++;
        }

        $this->info("✅ $count fichiers audités.");
        $this->info("🎨 Assure-toi que tous utilisent le même layout et les mêmes classes de style.");
        return 0;
    }
}
