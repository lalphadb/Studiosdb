#!/bin/bash

echo "=== Vérification Finale StudiosUnisDB ==="
echo ""

# 1. Vérifier les erreurs d'autoload
echo "1. Vérification Autoload:"
composer dump-autoload -o 2>&1 | grep -E "(Warning|Error|Skipping)" || echo "✓ Autoload OK"

# 2. Vérifier la configuration
echo -e "\n2. Vérification Configuration:"
php artisan config:cache 2>&1 | grep -E "(Error|Exception)" || echo "✓ Configuration OK"

# 3. Vérifier les routes
echo -e "\n3. Vérification Routes:"
php artisan route:cache 2>&1 | grep -E "(Error|Exception)" || echo "✓ Routes OK"

# 4. Vérifier les services
echo -e "\n4. Test AuthService:"
php -r "
require 'vendor/autoload.php';
\$app = require_once 'bootstrap/app.php';
\$kernel = \$app->make(Illuminate\Contracts\Console\Kernel::class);
\$kernel->bootstrap();
try {
    \$service = app(\App\Services\AuthService::class);
    echo '✓ AuthService OK';
} catch (Exception \$e) {
    echo '✗ AuthService Error: ' . \$e->getMessage();
}
echo PHP_EOL;
"

# 5. Statistiques
echo -e "\n5. Statistiques:"
echo "- Nombre de modèles: $(ls app/Models/*.php 2>/dev/null | wc -l)"
echo "- Nombre de contrôleurs: $(find app/Http/Controllers -name "*.php" 2>/dev/null | wc -l)"
echo "- Nombre de middlewares: $(ls app/Http/Middleware/*.php 2>/dev/null | wc -l)"
echo "- Taille du projet: $(du -sh . 2>/dev/null | cut -f1)"

echo -e "\n✅ Vérification terminée!"
