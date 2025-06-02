#!/bin/bash
# final-improvements.sh

echo "🎨 AMÉLIORATIONS FINALES DU DASHBOARD"
echo "====================================="

# 1. Améliorer les icônes et effets des cartes
echo "📝 Mise à jour de la vue superadmin avec icônes et animations..."
sed -i 's|<div class="stat-icon" style="background: rgba(23,162,184,0.2); color: #17a2b8;|<div class="stat-icon" style="background: linear-gradient(135deg, #17a2b8, #20c997);|g' resources/views/admin/dashboard/superadmin.blade.php
sed -i 's|<div class="stat-icon" style="background: rgba(245,158,11,0.2); color: #f59e0b;|<div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444);|g' resources/views/admin/dashboard/superadmin.blade.php
sed -i 's|<div class="stat-icon" style="background: rgba(139,92,246,0.2); color: #8b5cf6;|<div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);|g' resources/views/admin/dashboard/superadmin.blade.php
sed -i 's|<div class="stat-icon" style="background: rgba(16,185,129,0.2); color: #10b981;|<div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #3b82f6);|g' resources/views/admin/dashboard/superadmin.blade.php

# 2. Ajouter les animations CSS
echo "🎭 Ajout des animations et effets..."
cat >> public/css/studiosdb-glassmorphic-complete.css << 'EOF'

/* Animations pour les cartes du dashboard */
.stat-card-modern {
    transition: all 0.3s ease;
}

.stat-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.3),
        0 0 30px rgba(255, 255, 255, 0.1);
}

.stat-icon {
    color: white !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.stat-card-modern:hover .stat-icon {
    transform: scale(1.1);
}

/* Animation de pulsation pour les notifications */
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
    100% { transform: scale(1); opacity: 1; }
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Centrer la sidebar */
.theta-sidebar .nav-menu {
    padding: 20px 15px;
}

.theta-sidebar .nav-link {
    margin: 0 10px;
}

/* Améliorer la visibilité */
.content-card {
    background: rgba(255, 255, 255, 0.04) !important;
}

.stat-value {
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

/* Effet de glow sur les chiffres */
.stat-card-modern:hover .stat-value {
    text-shadow: 
        0 0 10px rgba(255, 255, 255, 0.5),
        0 2px 4px rgba(0, 0, 0, 0.3);
}
EOF

# 3. Corriger la sidebar dans le layout
echo "🔧 Centrage de la sidebar..."
sed -i 's|padding: 20px 15px;|padding: 20px 10px;|g' resources/views/layouts/admin.blade.php
sed -i 's|margin-bottom: 5px;|margin: 5px 10px;|g' resources/views/layouts/admin.blade.php

echo "✅ Améliorations terminées !"
