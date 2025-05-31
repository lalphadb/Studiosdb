#!/bin/bash

# Script d'installation STUDIOSUNISDB pour Ubuntu
# Usage: bash install-studiosdb.sh

set -e  # Arrêter en cas d'erreur

echo "====================================================="
echo "STUDIOSUNISDB - INSTALLATION COMPLETE"
echo "====================================================="
echo ""

# Vérifier qu'on est dans le bon répertoire
if [ ! -f "artisan" ]; then
    echo "Erreur: Ce script doit être exécuté depuis la racine du projet Laravel"
    exit 1
fi

# Fonction pour créer des répertoires si nécessaire
create_dir_if_not_exists() {
    if [ ! -d "$1" ]; then
        mkdir -p "$1"
        echo "✓ Répertoire créé: $1"
    fi
}

# ÉTAPE 1: CORRECTIONS VISUELLES
echo ""
echo "===== ÉTAPE 1: CORRECTIONS VISUELLES ====="

# Backup du CSS original
if [ -f "public/css/studiosdb-unified.css" ]; then
    cp public/css/studiosdb-unified.css public/css/studiosdb-unified.css.backup
    echo "✓ Backup CSS créé"
fi

# Créer le patch CSS pour le zoom
cat > public/css/zoom-fix.css << 'EOF'
/* PATCH ZOOM FIX - STUDIOSUNISDB */
:root {
    --sidebar-width: 260px;
    --sidebar-collapsed: 60px;
}

/* Reset box-sizing global */
*, *::before, *::after {
    box-sizing: border-box;
}

/* Correction du container principal */
html {
    font-size: 16px;
}

body {
    font-size: 1rem;
    line-height: 1.5;
}

.admin-wrapper {
    display: flex;
    min-height: 100vh;
    width: 100%;
}

.admin-main {
    flex: 1;
    margin-left: var(--sidebar-width);
    transition: margin-left 0.3s ease;
    width: calc(100% - var(--sidebar-width));
}

.admin-main.sidebar-collapsed {
    margin-left: var(--sidebar-collapsed);
    width: calc(100% - var(--sidebar-collapsed));
}

.admin-content,
.content-wrapper {
    max-width: 100%;
    padding: clamp(1rem, 2vw, 2rem);
    overflow-x: hidden;
}

.container {
    max-width: min(100%, 1400px);
    margin: 0 auto;
    padding: 0 1rem;
    width: 100%;
}

/* Fix pour les tableaux */
.table-responsive {
    max-width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

table {
    min-width: 100%;
    border-collapse: collapse;
}

/* Ajustements responsive */
@media (max-width: 1400px) {
    .container {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .admin-main {
        margin-left: 0;
        width: 100%;
    }
    .admin-sidebar {
        transform: translateX(-100%);
    }
    .admin-sidebar.mobile-open {
        transform: translateX(0);
    }
}
EOF

# Ajouter l'import dans le CSS principal
if [ -f "public/css/studiosdb-unified.css" ]; then
    # Ajouter l'import au début du fichier s'il n'existe pas déjà
    if ! grep -q "zoom-fix.css" public/css/studiosdb-unified.css; then
        echo "@import url('zoom-fix.css');" | cat - public/css/studiosdb-unified.css > temp && mv temp public/css/studiosdb-unified.css
    fi
fi

echo "✓ Correction zoom appliquée"

# ÉTAPE 2: SIDEBAR RÉTRACTABLE
echo ""
echo "===== ÉTAPE 2: SIDEBAR RÉTRACTABLE ====="

create_dir_if_not_exists "public/js"

# Créer le JavaScript pour la sidebar
cat > public/js/sidebar-toggle.js << 'EOF'
// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar') || document.querySelector('.admin-sidebar');
    const main = document.querySelector('.admin-main');
    let toggleBtn = document.querySelector('.sidebar-toggle-btn');
    
    // Créer le bouton s'il n'existe pas
    if (!toggleBtn) {
        toggleBtn = document.createElement('button');
        toggleBtn.className = 'sidebar-toggle-btn';
        toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
        toggleBtn.setAttribute('aria-label', 'Toggle sidebar');
        toggleBtn.setAttribute('title', 'Toggle sidebar');
        document.body.appendChild(toggleBtn);
    }
    
    // Toggle functionality
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('sidebar-collapsed');
        
        // Sauvegarder l'état
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebar-state', isCollapsed ? 'collapsed' : 'expanded');
        
        // Changer l'icône
        toggleBtn.innerHTML = isCollapsed ? '<i class="fas fa-chevron-right"></i>' : '<i class="fas fa-bars"></i>';
    });
    
    // Restaurer l'état sauvegardé
    const savedState = localStorage.getItem('sidebar-state');
    if (savedState === 'collapsed') {
        sidebar.classList.add('collapsed');
        main.classList.add('sidebar-collapsed');
        toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
    }
    
    // Mobile menu overlay
    let overlay = document.querySelector('.mobile-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'mobile-overlay';
        document.body.appendChild(overlay);
    }
    
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('active');
    });
    
    // Mobile toggle
    const mobileToggle = () => {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }
    };
    
    // Attach mobile toggle to button on small screens
    window.addEventListener('resize', () => {
        if (window.innerWidth <= 768) {
            toggleBtn.removeEventListener('click', toggleBtn._desktopHandler);
            toggleBtn.addEventListener('click', mobileToggle);
        }
    });
});
EOF

# Créer le CSS pour la sidebar
cat > public/css/sidebar-toggle.css << 'EOF'
/* Sidebar Toggle Styles */
.sidebar-toggle-btn {
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1001;
    width: 40px;
    height: 40px;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all var(--transition-speed) ease;
}

.sidebar-toggle-btn:hover {
    background: var(--glass-bg-hover);
    transform: scale(1.05);
}

.admin-sidebar {
    width: var(--sidebar-width);
    transition: width 0.3s ease;
}

.admin-sidebar.collapsed {
    width: var(--sidebar-collapsed);
}

.admin-sidebar.collapsed .sidebar-label {
    display: none;
}

.admin-sidebar.collapsed .sidebar-item {
    justify-content: center;
}

.admin-sidebar.collapsed .sidebar-icon {
    margin-right: 0;
}

/* Mobile overlay */
.mobile-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 998;
    display: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mobile-overlay.active {
    display: block;
    opacity: 1;
}

@media (max-width: 768px) {
    .admin-sidebar {
        position: fixed;
        z-index: 999;
        height: 100%;
    }
}
EOF

# Ajouter l'import CSS
if ! grep -q "sidebar-toggle.css" public/css/studiosdb-unified.css; then
    echo "@import url('sidebar-toggle.css');" >> public/css/studiosdb-unified.css
fi

echo "✓ Sidebar rétractable ajoutée"

# ÉTAPE 3: UNIFORMISATION DES FORMULAIRES
echo ""
echo "===== ÉTAPE 3: UNIFORMISATION FORMULAIRES ====="

cat > public/css/forms-glassmorphic.css << 'EOF'
/* Glassmorphic Form Styles */
/* Base form elements */
.form-control,
.form-select,
input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
input[type="date"],
input[type="tel"],
textarea,
select {
    background: var(--glass-bg);
    backdrop-filter: blur(var(--blur-amount));
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-md);
    color: var(--text-primary);
    padding: 0.75rem 1rem;
    width: 100%;
    font-size: 1rem;
    line-height: 1.5;
    transition: all var(--transition-speed) ease;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}

/* Placeholder styles */
.form-control::placeholder,
input::placeholder,
textarea::placeholder {
    color: var(--text-muted);
    opacity: 0.7;
}

/* Focus states */
.form-control:focus,
input:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: var(--accent-primary);
    background: var(--glass-bg-hover);
    box-shadow: 0 0 0 3px rgba(0, 212, 255, 0.1);
}

/* Focus visible for keyboard navigation */
.form-control:focus-visible,
input:focus-visible,
textarea:focus-visible,
select:focus-visible,
button:focus-visible,
a:focus-visible {
    outline: 2px solid var(--accent-primary);
    outline-offset: 2px;
}

/* Hover states */
.form-control:hover:not(:focus),
input:hover:not(:focus),
textarea:hover:not(:focus),
select:hover:not(:focus) {
    border-color: var(--glass-border-hover);
    background: var(--glass-bg-hover);
}

/* Disabled states */
.form-control:disabled,
input:disabled,
textarea:disabled,
select:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background: var(--glass-bg);
}

/* Labels */
.form-label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-primary);
    font-weight: 500;
    font-size: 0.875rem;
}

/* Required field indicator */
.form-label.required::after {
    content: " *";
    color: var(--accent-red);
}

/* Form groups */
.form-group {
    margin-bottom: 1.5rem;
}

/* Error states */
.form-control.is-invalid,
input.is-invalid,
textarea.is-invalid,
select.is-invalid {
    border-color: var(--accent-red);
}

.invalid-feedback {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: var(--accent-red);
}

/* Help text */
.form-text {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Checkboxes and radios */
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.form-check-input {
    width: 1.25rem;
    height: 1.25rem;
    margin-right: 0.5rem;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: var(--radius-sm);
    cursor: pointer;
}

.form-check-input[type="checkbox"] {
    border-radius: var(--radius-sm);
}

.form-check-input[type="radio"] {
    border-radius: 50%;
}

.form-check-input:checked {
    background-color: var(--accent-primary);
    border-color: var(--accent-primary);
}

/* Buttons */
.btn {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 500;
    border-radius: var(--radius-md);
    border: 1px solid transparent;
    cursor: pointer;
    transition: all var(--transition-speed) ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary {
    background: var(--accent-primary);
    color: white;
}

.btn-primary:hover {
    background: var(--accent-primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 212, 255, 0.3);
}

.btn-secondary {
    background: var(--glass-bg);
    color: var(--text-primary);
    border: 1px solid var(--glass-border);
}

.btn-secondary:hover {
    background: var(--glass-bg-hover);
    border-color: var(--accent-primary);
}
EOF

if ! grep -q "forms-glassmorphic.css" public/css/studiosdb-unified.css; then
    echo "@import url('forms-glassmorphic.css');" >> public/css/studiosdb-unified.css
fi

echo "✓ Uniformisation des formulaires appliquée"

# ÉTAPE 4: FOOTER LOI 25
echo ""
echo "===== ÉTAPE 4: FOOTER LOI 25 ====="

create_dir_if_not_exists "resources/views/components"

cat > resources/views/components/footer-loi25.blade.php << 'EOF'
<footer class="footer-loi25">
    <div class="footer-container">
        <div class="footer-content">
            <!-- Logo et info principale -->
            <div class="footer-section">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Studios Unis" onerror="this.style.display='none'">
                    <h3>Studios Unis</h3>
                </div>
                <p class="footer-tagline">Système de gestion conforme à la Loi 25</p>
            </div>
            
            <!-- Liens légaux -->
            <div class="footer-section">
                <h4>Protection des données</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('privacy-policy') }}">Politique de confidentialité</a></li>
                    <li><a href="{{ route('terms') }}">Conditions d'utilisation</a></li>
                    <li><a href="{{ route('data-collection') }}">Avis de collecte</a></li>
                    <li><a href="{{ route('access-rights') }}">Droits d'accès et rectification</a></li>
                    <li><a href="{{ route('consent-management') }}">Gestion des consentements</a></li>
                </ul>
            </div>
            
            <!-- Responsable protection -->
            <div class="footer-section">
                <h4>Responsable de la protection</h4>
                <div class="privacy-officer">
                    <p><strong>{{ config('app.privacy_officer_name', 'Jean Tremblay') }}</strong></p>
                    <p>Responsable de la protection des renseignements personnels</p>
                    <p><a href="mailto:{{ config('app.privacy_officer_email', 'protection@studiosunis.com') }}">
                        {{ config('app.privacy_officer_email', 'protection@studiosunis.com') }}
                    </a></p>
                    <p>{{ config('app.privacy_officer_phone', '1-888-555-0123') }}</p>
                </div>
            </div>
            
            <!-- Conformité -->
            <div class="footer-section">
                <h4>Conformité Loi 25</h4>
                <div class="compliance-info">
                    <p class="compliance-badge">
                        <i class="fas fa-shield-alt"></i>
                        Conforme à la Loi 25
                    </p>
                    <p>Protection des renseignements personnels</p>
                    <p>N° d'enregistrement: {{ config('app.law25_registration_number', 'QC-2024-001') }}</p>
                    <p class="last-update">Dernière mise à jour: {{ now()->format('d F Y') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Studios Unis. Tous droits réservés. | 
                <a href="#" id="cookie-preferences">Préférences de cookies</a>
            </p>
        </div>
    </div>
</footer>

<style>
.footer-loi25 {
    background: var(--glass-bg);
    backdrop-filter: blur(var(--blur-amount));
    border-top: 1px solid var(--glass-border);
    margin-top: auto;
    padding: 3rem 0 1rem;
}

.footer-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 3rem;
    margin-bottom: 2rem;
}

.footer-section h3,
.footer-section h4 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.footer-logo {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.footer-logo img {
    height: 40px;
    width: auto;
}

.footer-tagline {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color var(--transition-speed);
}

.footer-links a:hover {
    color: var(--accent-primary);
}

.privacy-officer p,
.compliance-info p {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.compliance-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--accent-green);
    font-weight: 600;
}

.last-update {
    font-size: 0.8rem;
    color: var(--text-muted);
    font-style: italic;
}

.footer-bottom {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid var(--glass-border);
    color: var(--text-muted);
    font-size: 0.85rem;
}

.footer-bottom a {
    color: var(--text-secondary);
    text-decoration: none;
}

.footer-bottom a:hover {
    color: var(--accent-primary);
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .footer-loi25 {
        padding: 2rem 0 1rem;
    }
}
</style>

<script>
document.getElementById('cookie-preferences')?.addEventListener('click', function(e) {
    e.preventDefault();
    // Ouvrir le gestionnaire de cookies
    if (typeof openCookieConsent === 'function') {
        openCookieConsent();
    } else {
        alert('Le gestionnaire de préférences de cookies sera bientôt disponible.');
    }
});
</script>
EOF

echo "✓ Footer Loi 25 créé"

# ÉTAPE 5: SERVICE D'EXPORT
echo ""
echo "===== ÉTAPE 5: SERVICE D'EXPORT ====="

create_dir_if_not_exists "app/Services"

cat > app/Services/ExportService.php << 'EOF'
<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;

class ExportService
{
    protected $privacyFields = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];
    
    public function export($modelClass, $format = 'csv', $fields = [], $filters = [], $options = [])
    {
        $query = $modelClass::query();
        
        // Appliquer les filtres
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $query->where($field, $value);
            }
        }
        
        // Récupérer les données
        $data = $query->get();
        
        // Filtrer les champs si spécifiés
        if (!empty($fields)) {
            $data = $data->map(function ($item) use ($fields) {
                return collect($item->toArray())->only($fields)->all();
            });
        }
        
        // Supprimer les champs sensibles
        $data = $this->removePrivacyFields($data);
        
        // Anonymiser si demandé
        if ($options['anonymize'] ?? false) {
            $data = $this->anonymizeData($data);
        }
        
        // Exporter selon le format
        switch ($format) {
            case 'pdf':
                return $this->exportPdf($data, $modelClass);
            case 'excel':
                return $this->exportExcel($data, $modelClass);
            case 'csv':
            default:
                return $this->exportCsv($data, $modelClass);
        }
    }
    
    protected function removePrivacyFields($data)
    {
        return $data->map(function ($item) {
            return collect($item)->except($this->privacyFields)->all();
        });
    }
    
    protected function anonymizeData($data)
    {
        return $data->map(function ($item, $index) {
            $item = collect($item);
            
            // Anonymiser les champs sensibles
            if ($item->has('email')) {
                $item['email'] = 'user' . ($index + 1) . '@example.com';
            }
            
            if ($item->has('telephone')) {
                $item['telephone'] = '***-***-' . substr($item['telephone'], -4);
            }
            
            if ($item->has('nom')) {
                $item['nom'] = 'Membre ' . ($index + 1);
            }
            
            if ($item->has('prenom')) {
                $item['prenom'] = 'Anonyme';
            }
            
            if ($item->has('adresse')) {
                $item['adresse'] = '*** Rue Anonyme';
            }
            
            return $item->all();
        });
    }
    
    protected function exportPdf($data, $modelClass)
    {
        $modelName = class_basename($modelClass);
        $timestamp = now()->format('Y-m-d_H-i-s');
        
        $pdf = PDF::loadView('exports.pdf', [
            'data' => $data,
            'title' => "Export {$modelName}",
            'date' => now()->format('d/m/Y H:i'),
            'fields' => $data->first() ? array_keys($data->first()) : []
        ]);
        
        return $pdf->download("export_{$modelName}_{$timestamp}.pdf");
    }
    
    protected function exportExcel($data, $modelClass)
    {
        $modelName = class_basename($modelClass);
        $timestamp = now()->format('Y-m-d_H-i-s');
        
        return Excel::download(
            new GenericExport($data),
            "export_{$modelName}_{$timestamp}.xlsx"
        );
    }
    
    protected function exportCsv($data, $modelClass)
    {
        $modelName = class_basename($modelClass);
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "export_{$modelName}_{$timestamp}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];
        
        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            
            // En-têtes
            if ($data->isNotEmpty()) {
                fputcsv($file, array_keys($data->first()));
            }
            
            // Données
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
EOF

echo "✓ Service d'export créé"

# ÉTAPE 6: SYSTÈME DE CONSENTEMENTS
echo ""
echo "===== ÉTAPE 6: SYSTÈME DE CONSENTEMENTS ====="

# Créer la migration
cat > database/migrations/2024_01_01_000001_create_consent_tables.php << 'EOF'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Types de consentements
        Schema::create('consent_types', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('name');
            $table->text('description');
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('version')->default(1);
            $table->timestamps();
        });
        
        // Consentements des utilisateurs
        Schema::create('user_consents', function (Blueprint $table) {
            $table->id();
            $table->morphs('consentable'); // user ou membre
            $table->foreignId('consent_type_id')->constrained();
            $table->boolean('is_granted');
            $table->timestamp('granted_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('source'); // web, api, import, etc.
            $table->integer('version');
            $table->text('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['consentable_type', 'consentable_id']);
            $table->index('consent_type_id');
        });
        
        // Historique des consentements
        Schema::create('consent_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_consent_id')->constrained();
            $table->string('action'); // granted, revoked, updated
            $table->boolean('previous_value')->nullable();
            $table->boolean('new_value');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('consent_history');
        Schema::dropIfExists('user_consents');
        Schema::dropIfExists('consent_types');
    }
};
EOF

echo "✓ Migration des consentements créée"

# ÉTAPE 7: CONFIGURATION FINALE
echo ""
echo "===== ÉTAPE 7: CONFIGURATION FINALE ====="

# Ajouter les variables d'environnement si elles n'existent pas
if ! grep -q "PRIVACY_OFFICER_NAME" .env; then
    cat >> .env << 'EOF'

# Loi 25 Configuration
PRIVACY_OFFICER_NAME="Jean Tremblay"
PRIVACY_OFFICER_EMAIL="protection@studiosunis.com"
PRIVACY_OFFICER_PHONE="1-888-555-0123"
LAW25_REGISTRATION_NUMBER="QC-2024-001"
EOF
fi

echo "✓ Variables d'environnement ajoutées"

# Installation des packages manquants
echo ""
echo "===== INSTALLATION DES PACKAGES ====="
composer require spatie/laravel-activitylog --no-interaction
composer require spatie/laravel-permission --no-interaction

# Exécution des commandes Laravel
echo ""
echo "===== EXÉCUTION DES COMMANDES LARAVEL ====="
php artisan migrate --force
php artisan storage:link
php artisan optimize

# Build des assets
echo ""
echo "===== BUILD DES ASSETS ====="
if [ -f "package.json" ]; then
    npm install
    npm run build
fi

echo ""
echo "====================================================="
echo "✅ INSTALLATION TERMINÉE !"
echo "====================================================="
echo ""
echo "Prochaines étapes :"
echo "1. Vérifier que toutes les fonctionnalités fonctionnent"
echo "2. Tester le système de consentements"
echo "3. Personnaliser les pages légales selon vos besoins"
echo "4. Configurer les permissions appropriées"
echo ""
echo "N'oubliez pas de :"
echo "- Redémarrer Apache : sudo systemctl restart apache2"
echo "- Vider le cache du navigateur"
echo "- Tester en navigation privée"
echo ""
