<?php

use App\Models\Ecole;
use App\Models\User;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Chercher l'école St-Émile
$ecoles = Ecole::where('nom', 'LIKE', '%St-Émile%')
    ->orWhere('nom', 'LIKE', '%St-Emile%')
    ->get();

if ($ecoles->isEmpty()) {
    echo "❌ Aucune école St-Émile trouvée\n";
    echo "\nListe de toutes les écoles:\n";
    Ecole::orderBy('nom')->get()->each(function($e) {
        echo "- {$e->nom} (ID: {$e->id})\n";
    });
} else {
    foreach ($ecoles as $ecole) {
        echo "✅ École trouvée: {$ecole->nom} (ID: {$ecole->id})\n";
        
        $admins = User::where('ecole_id', $ecole->id)
            ->whereIn('role', ['admin', 'superadmin'])
            ->get();
        
        if ($admins->isEmpty()) {
            echo "   ⚠️  Aucun admin pour cette école\n";
        } else {
            echo "   👥 Admins ({$admins->count()}):\n";
            foreach ($admins as $admin) {
                echo "      - {$admin->name} ({$admin->email}) - Role: {$admin->role}\n";
            }
        }
        echo "\n";
    }
}

// Afficher aussi les superadmins (qui peuvent gérer toutes les écoles)
$superadmins = User::where('role', 'superadmin')->get();
if ($superadmins->isNotEmpty()) {
    echo "\n🔑 Superadmins (accès à toutes les écoles):\n";
    foreach ($superadmins as $sa) {
        echo "   - {$sa->name} ({$sa->email})\n";
    }
}
