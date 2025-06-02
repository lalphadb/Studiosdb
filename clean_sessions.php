<?php
// Script pour nettoyer les sessions expirées

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Nettoyer les sessions de plus de 24h
$deleted = DB::table('sessions')
    ->where('last_activity', '<', Carbon::now()->subHours(24)->timestamp)
    ->delete();

echo "Sessions supprimées: $deleted\n";

// Nettoyer aussi le cache si configuré en DB
if (config('cache.default') === 'database') {
    $deletedCache = DB::table('cache')
        ->where('expiration', '<', time())
        ->delete();
    
    echo "Entrées de cache supprimées: $deletedCache\n";
}
