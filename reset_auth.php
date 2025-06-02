<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// 1. Déconnecter tout le monde
echo "Déconnexion de tous les utilisateurs...\n";
DB::table('sessions')->truncate();
echo "✓ Toutes les sessions supprimées\n\n";

// 2. Lister les utilisateurs
echo "Utilisateurs existants:\n";
echo str_pad("ID", 5) . str_pad("Email", 30) . str_pad("Role", 15) . str_pad("Active", 10) . "\n";
echo str_repeat("-", 60) . "\n";

$users = User::all();
foreach ($users as $user) {
    echo str_pad($user->id, 5) . 
         str_pad($user->email, 30) . 
         str_pad($user->role, 15) . 
         str_pad($user->active ? 'Oui' : 'Non', 10) . "\n";
}

// 3. Demander quel utilisateur modifier
echo "\nEntrez l'ID de l'utilisateur à modifier (ou 'q' pour quitter): ";
$handle = fopen("php://stdin", "r");
$line = trim(fgets($handle));

if ($line !== 'q' && is_numeric($line)) {
    $user = User::find($line);
    if ($user) {
        echo "Nouveau mot de passe pour {$user->email}: ";
        $password = trim(fgets($handle));
        
        $user->password = Hash::make($password);
        $user->active = true;
        $user->login_attempts = 0;
        $user->locked_until = null;
        $user->save();
        
        echo "\n✓ Mot de passe mis à jour!\n";
        echo "Email: {$user->email}\n";
        echo "Mot de passe: {$password}\n";
    }
}

fclose($handle);
