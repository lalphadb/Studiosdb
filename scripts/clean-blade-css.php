#!/usr/bin/env php
<?php

/**
 * Vérifie que le CSS principal est bien inclus dans les layouts
 */

$baseDir = '/var/www/html/studiosdb';
$layoutsDir = $baseDir . '/resources/views/layouts';

echo "\n🔍 VÉRIFICATION DE L'INCLUSION CSS\n";
echo str_repeat("=", 50) . "\n\n";

// Fichiers de layout à vérifier
$layouts = ['admin.blade.php', 'app.blade.php', 'guest.blade.php'];

foreach ($layouts as $layout) {
    $path = $layoutsDir . '/' . $layout;
    
    if (file_exists($path)) {
        $content = file_get_contents($path);
        
        echo "📄 $layout: ";
        
        if (strpos($content, 'studiosdb-glassmorphic-complete.css') !== false) {
            echo "✅ CSS inclus\n";
        } else {
            echo "❌ CSS non trouvé - Ajoutez cette ligne dans <head>:\n";
            echo "   <link rel=\"stylesheet\" href=\"{{ asset('css/studiosdb-glassmorphic-complete.css') }}\">\n";
        }
    } else {
        echo "📄 $layout: ⚠️  Fichier non trouvé\n";
    }
}

echo "\n";
