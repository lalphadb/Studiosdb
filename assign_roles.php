<?php
require_once '/var/www/html/studiosdb/vendor/autoload.php';
$app = require_once '/var/www/html/studiosdb/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

try {
    // Assigner superadmin
    $admin = User::find(1);
    if ($admin) {
        $admin->assignRole('superadmin');
        echo "✓ Rôle superadmin assigné à " . $admin->name . "\n";
    }

    // Assigner admin aux autres
    $users = User::whereIn('id', [7, 8, 9])->get();
    foreach ($users as $user) {
        $user->assignRole('admin');
        echo "✓ Rôle admin assigné à " . $user->name . "\n";
    }

    echo "\nTerminé avec succès!\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}

