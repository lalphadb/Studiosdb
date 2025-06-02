#!/bin/bash

echo "🔧 Correction des noms de routes dans les vues..."

# Fonction pour corriger les routes
fix_route_names() {
    local route=$1
    echo "  → Correction de route('$route.*') vers route('admin.$route.*')"
    
    # Corriger dans tous les fichiers blade
    find resources/views -name "*.blade.php" -type f -exec sed -i "s/route('$route\./route('admin.$route./g" {} \;
    find resources/views -name "*.blade.php" -type f -exec sed -i "s/routeIs('$route\./routeIs('admin.$route./g" {} \;
}

# Corriger toutes les routes admin
routes=("membres" "cours" "ecoles" "sessions" "inscriptions" "presences" "seminaires")

for route in "${routes[@]}"; do
    fix_route_names "$route"
done

# Cas spéciaux pour le dashboard
echo "  → Correction des routes dashboard"
find resources/views -name "*.blade.php" -type f -exec sed -i "s/route('dashboard')/route('admin.dashboard')/g" {} \;

# Vider les caches
echo "🧹 Nettoyage des caches..."
php artisan view:clear
php artisan route:clear
php artisan cache:clear

echo "✅ Corrections terminées!"
