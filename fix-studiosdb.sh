#!/bin/bash

echo "🔧 Correction automatique de STUDIOSUNISDB..."

# 1. Backup des fichiers
echo "📦 Création des backups..."
cp public/css/studiosdb-glassmorphic-complete.css public/css/studiosdb-glassmorphic-complete.css.backup-$(date +%Y%m%d-%H%M%S)

# 2. Créer le fichier de correction CSS
echo "🎨 Création du CSS de correction..."
cat > /tmp/theta-fix.css << 'EOF'

/* ========== CORRECTION AUTOMATIQUE THETA - $(date) ========== */

/* OVERRIDE FORCÉ POUR THETA */
.theta-wrapper {
  display: flex;
  min-height: 100vh;
}

.theta-sidebar {
  width: 260px !important;
  height: 100vh !important;
  background: rgba(29, 35, 42, 0.95) !important;
  backdrop-filter: blur(20px) !important;
  -webkit-backdrop-filter: blur(20px) !important;
  border-right: 1px solid rgba(32, 185, 190, 0.3) !important;
  box-shadow: 0 0 30px rgba(0, 212, 255, 0.3) !important;
  position: fixed !important;
  left: 0 !important;
  top: 0 !important;
  z-index: 1000 !important;
}

.theta-main {
  margin-left: 260px !important;
  width: calc(100% - 260px) !important;
  min-height: 100vh;
  background: #1a1d21 !important;
}

/* Fix pour les liens */
.theta-sidebar .nav-menu {
  padding: 0 15px !important;
  list-style: none !important;
  margin: 0 !important;
}

.theta-sidebar .nav-menu a {
  display: flex !important;
  align-items: center !important;
  padding: 14px 20px !important;
  color: rgba(255, 255, 255, 0.8) !important;
  text-decoration: none !important;
  border-radius: 12px !important;
  transition: all 0.3s ease !important;
  position: relative !important;
  overflow: hidden !important;
  font-size: 14px !important;
  font-weight: 500 !important;
  background: rgba(255, 255, 255, 0.03) !important;
  border: 1px solid transparent !important;
  margin-bottom: 5px !important;
  cursor: pointer !important;
  pointer-events: auto !important;
  z-index: 10 !important;
}

.theta-sidebar .nav-menu a:hover {
  background: rgba(32, 185, 190, 0.15) !important;
  color: #ffffff !important;
  transform: translateX(5px) !important;
  border-color: rgba(32, 185, 190, 0.3) !important;
}

.theta-sidebar .nav-menu a.active {
  background: linear-gradient(135deg, rgba(32, 185, 190, 0.25) 0%, rgba(0, 202, 255, 0.25) 100%) !important;
  color: #00caff !important;
  border-left: 3px solid #00caff !important;
  font-weight: 600 !important;
}

/* Header/Logo */
.theta-sidebar .sidebar-header {
  padding: 25px 20px !important;
  background: rgba(0, 0, 0, 0.3) !important;
  border-bottom: 2px solid rgba(32, 185, 190, 0.3) !important;
  margin-bottom: 20px !important;
  text-align: center !important;
}

/* Logo styles */
.theta-sidebar .sidebar-header a {
  color: #00caff !important;
  text-decoration: none !important;
  font-size: 24px !important;
  font-weight: 700 !important;
  display: block !important;
}

/* Icônes fixes */
.theta-sidebar .nav-menu a i {
  margin-right: 12px !important;
  width: 20px !important;
  text-align: center !important;
  font-size: 16px !important;
}

/* Footer utilisateur */
.theta-sidebar .sidebar-footer {
  position: absolute !important;
  bottom: 0 !important;
  left: 0 !important;
  right: 0 !important;
  padding: 20px !important;
  background: rgba(0, 0, 0, 0.4) !important;
  border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
}

/* Fix pour les liens non cliquables */
.theta-sidebar * {
  pointer-events: auto !important;
}

/* Cartes du dashboard */
.theta-main .card,
.theta-main [class*="card"] {
  background: rgba(41, 50, 55, 0.95) !important;
  backdrop-filter: blur(10px) !important;
  border: 1px solid rgba(255, 255, 255, 0.1) !important;
  border-radius: 15px !important;
}

EOF

# 3. Ajouter le fix au CSS principal
echo "📝 Ajout du fix au CSS principal..."
cat /tmp/theta-fix.css >> public/css/studiosdb-glassmorphic-complete.css

# 4. Corriger l'erreur Chart.js dans tous les fichiers Blade
echo "📊 Correction de Chart.js..."
find resources/views -name "*.blade.php" -type f -exec sed -i 's|https://cdn.jsdelivr.net/npm/chart.js|https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js|g' {} \;

# 5. Créer un fichier JS pour forcer les corrections
echo "🔨 Création du script JS de correction..."
cat > public/js/theta-fix.js << 'EOF'
document.addEventListener('DOMContentLoaded', function() {
    // Forcer les liens à être cliquables
    const links = document.querySelectorAll('.theta-sidebar a');
    links.forEach(link => {
        link.style.pointerEvents = 'auto';
        link.style.cursor = 'pointer';
        
        // Ajouter un listener de secours
        link.addEventListener('click', function(e) {
            if (this.href && this.href !== '#') {
                window.location.href = this.href;
            }
        });
    });
    
    // Fix pour la sidebar
    const sidebar = document.querySelector('.theta-sidebar');
    if (sidebar) {
        sidebar.style.zIndex = '1000';
    }
    
    console.log('✅ Theta fixes appliqués');
});
EOF

# 6. Ajouter le script JS aux layouts
echo "🔗 Recherche des layouts..."
for file in resources/views/layouts/*.blade.php; do
    if [ -f "$file" ]; then
        # Vérifier si le script n'est pas déjà inclus
        if ! grep -q "theta-fix.js" "$file"; then
            # Ajouter avant </body>
            sed -i '/<\/body>/i <script src="{{ asset('\''js/theta-fix.js'\'') }}"></script>' "$file"
            echo "✅ Script ajouté à: $file"
        fi
    fi
done

# 7. Vider tous les caches Laravel
echo "🧹 Nettoyage des caches..."
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear

# 8. Recompiler si nécessaire
if [ -f "package.json" ]; then
    echo "📦 Recompilation des assets..."
    npm run dev 2>/dev/null || npm run build 2>/dev/null || echo "⚠️  Compilation manuelle requise"
fi

# 9. Permissions
echo "🔐 Correction des permissions..."
chmod -R 755 public/css
chmod -R 755 public/js

# 10. Message final
echo ""
echo "✅ ================================="
echo "✅ CORRECTIONS APPLIQUÉES !"
echo "✅ ================================="
echo ""
echo "📌 Actions effectuées :"
echo "   - CSS corrigé et sauvegardé"
echo "   - Chart.js URL corrigée"
echo "   - Script JS de fix ajouté"
echo "   - Caches vidés"
echo ""
echo "🔄 Pour recharger dans le navigateur :"
echo "   Firefox/Chrome Linux : Ctrl + Shift + R"
echo "   Ou dans le navigateur : F5 en maintenant Shift"
echo ""
echo "💡 Si les problèmes persistent :"
echo "   1. Ouvrez la console du navigateur (F12)"
echo "   2. Onglet Network, cochez 'Disable cache'"
echo "   3. Rechargez la page"
echo ""
