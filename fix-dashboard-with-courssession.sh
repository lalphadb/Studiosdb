# fix-dashboard-with-courssession.sh

echo "🔧 ADAPTATION DU DASHBOARD POUR UTILISER COURSSESSION"
echo "===================================================="

# Remplacer Session par CoursSession dans le controller
sed -i 's/use App\\Models\\Session;/use App\\Models\\CoursSession;/' app/Http/Controllers/Admin/DashboardController.php
sed -i 's/Session::/CoursSession::/g' app/Http/Controllers/Admin/DashboardController.php

echo "✅ DashboardController modifié pour utiliser CoursSession"
