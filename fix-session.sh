#!/bin/bash
# fix-session-model.sh

echo "🔧 CORRECTION DU MODÈLE SESSION POUR STUDIOSDB"
echo "============================================="

# 1. Créer le modèle Session
cat > app/Models/Session.php << 'EOF'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'cours_id',
        'date_debut',
        'date_fin',
        'places_max',
        'statut',
        'notes'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    // Relations
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(InscriptionCours::class);
    }
}
EOF

# 2. Vérifier la structure de la table sessions
echo "📊 Structure de la table sessions :"
mysql -u root -p studiosdb -e "DESCRIBE sessions;"

# 3. Permissions
chown lalpha:www-data app/Models/Session.php
chmod 755 app/Models/Session.php

# 4. Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 5. Redémarrer Apache
sudo systemctl restart apache2

echo "✅ Modèle Session créé avec succès !"
