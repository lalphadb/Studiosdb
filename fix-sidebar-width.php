<?php
// fix-sidebar-width.php

$cssFile = 'public/css/studiosdb-glassmorphic-complete.css';
$content = file_get_contents($cssFile);

// Remplacer les largeurs
$content = str_replace('width: 220px', 'width: 260px', $content);
$content = str_replace('margin-left: 220px', 'margin-left: 260px', $content);

// Ajouter le fix à la fin
$fix = "

/* FIX SIDEBAR TRONQUÉE - AJOUTÉ AUTOMATIQUEMENT */
.theta-sidebar {
  width: 260px !important;
  min-width: 260px !important;
}

.theta-main {
  margin-left: 260px !important;
}

.theta-sidebar .nav-menu a {
  white-space: nowrap !important;
  overflow: visible !important;
}
";

file_put_contents($cssFile, $content . $fix);
echo "✅ Sidebar élargie avec succès!\n";
