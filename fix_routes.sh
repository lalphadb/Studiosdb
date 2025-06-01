#!/bin/bash

echo "🔧 Correction des routes dans les vues..."

# Backup des vues
cp -r resources/views resources/views.backup.$(date +%Y%m%d_%H%M%S)

# Corriger 'dashboard' en 'admin.dashboard'
find resources/views -name "*.blade.php" -exec sed -i "s/route('dashboard')/route('admin.dashboard')/g" {} \;
find resources/views -name "*.blade.php" -exec sed -i 's/route("dashboard")/route("admin.dashboard")/g' {} \;

# Afficher les modifications
echo "✅ Routes corrigées"
echo "📋 Vérification des routes dashboard:"
grep -r "dashboard" resources/views/ | grep route || echo "Aucune route dashboard trouvée"
