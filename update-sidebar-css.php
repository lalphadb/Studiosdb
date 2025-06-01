<?php
// update-sidebar-css.php

$cssFile = 'public/css/studiosdb-glassmorphic-complete.css';
$backupFile = 'public/css/studiosdb-glassmorphic-complete.css.backup';

// Créer une sauvegarde
if (!copy($cssFile, $backupFile)) {
    echo "❌ Erreur lors de la création de la sauvegarde\n";
    exit(1);
}

echo "✅ Sauvegarde créée : $backupFile\n";

// Lire le contenu du fichier
$content = file_get_contents($cssFile);

// Remplacements
$replacements = [
    '/.sidebar,' => '.theta-sidebar, .sidebar,',
    '/.sidebar {' => '.theta-sidebar, .sidebar {',
    '/.sidebar:' => '.theta-sidebar:not(.processed), .sidebar:',
    '/.sidebar .' => '.theta-sidebar ., .sidebar .',
    '/.admin-sidebar' => '.theta-sidebar, .admin-sidebar',
    '/.main-sidebar' => '.theta-sidebar, .main-sidebar',
];

foreach ($replacements as $search => $replace) {
    $content = str_replace($search, $replace, $content);
}

// Éviter les doublons
$content = str_replace('.theta-sidebar, .theta-sidebar,', '.theta-sidebar,', $content);

// Écrire le contenu modifié
file_put_contents($cssFile, $content);

echo "✅ CSS mis à jour avec succès!\n";
echo "📝 Les classes .theta-sidebar ont été ajoutées\n";
echo "💾 Sauvegarde disponible : $backupFile\n";
