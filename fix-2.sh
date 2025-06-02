#!/bin/bash
# clean-dashboard-errors.sh

echo "🧹 NETTOYAGE DES ERREURS RESTANTES"
echo "=================================="

# 1. Supprimer ou corriger le footer problématique
echo "📝 Correction du footer Loi 25..."
cat > resources/views/components/footer-loi25.blade.php << 'EOF'
<footer style="background: rgba(10, 10, 10, 0.8); border-top: 1px solid rgba(255, 255, 255, 0.1); padding: 15px 0; margin-top: auto;">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <p style="color: #7c7c94; margin: 0; font-size: 14px;">
                    © {{ date('Y') }} Studios Unis. Tous droits réservés. | 
                    <a href="{{ route('privacy-policy') }}" style="color: #00d4ff;">Politique de confidentialité</a> | 
                    <a href="{{ route('terms') }}" style="color: #00d4ff;">Conditions</a> | 
                    <a href="{{ route('contact') }}" style="color: #00d4ff;">Contact</a>
                </p>
            </div>
        </div>
    </div>
</footer>
EOF

# 2. Retirer les inclusions du footer du layout si nécessaire
echo "🔧 Nettoyage du layout..."
sed -i '/@include.*footer-loi25/d' resources/views/layouts/admin.blade.php

# 3. Ajouter un footer simple dans le layout admin
echo "📄 Ajout d'un footer simple..."
sed -i '/<\/main>/i\
            <footer class="admin-footer mt-auto">\
                <p class="mb-0">© {{ date('\''Y'\'') }} Studios Unis - Conformité Loi 25 du Québec</p>\
            </footer>' resources/views/layouts/admin.blade.php

# 4. Corriger les styles pour éviter le débordement
echo "🎨 Ajustement final des styles..."
cat > public/css/dashboard-final.css << 'EOF'
/* Corrections finales pour le dashboard */
.admin-wrapper {
    display: flex;
    min-height: 100vh;
}

.admin-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.content-area {
    flex: 1;
    padding: 20px 30px;
}

.admin-footer {
    background: rgba(10, 10, 10, 0.95);
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding: 15px 30px;
    text-align: center;
    color: #7c7c94;
    margin-top: auto;
}

/* Fix pour les cartes de stats */
.stat-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
}

.stat-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
}

.stat-icon.success { background: #00d4ff; }
.stat-icon.warning { background: #ff9500; }
.stat-icon.danger { background: #ff3b30; }
EOF

# 5. Ajouter le CSS au layout
sed -i '/<\/head>/i\<link rel="stylesheet" href="{{ asset('\''css/dashboard-final.css'\'') }}">' resources/views/layouts/admin.blade.php

# 6. Permissions
chown -R lalpha:www-data resources/views/
chown -R lalpha:www-data public/css/
chmod -R 755 resources/views/
chmod -R 755 public/css/

# 7. Vider le cache
php artisan cache:clear
php artisan view:clear

echo "✅ Nettoyage terminé !"
echo ""
echo "Le dashboard devrait maintenant fonctionner sans erreurs dans la console."
