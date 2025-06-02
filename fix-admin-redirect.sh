#!/bin/bash
# fix-admin-redirect.sh

echo "🔧 CORRECTION DE LA REDIRECTION ADMIN"
echo "====================================="

# 1. Corriger le LoginController
echo "📝 Mise à jour du LoginController..."
cat > app/Http/Controllers/Auth/LoginController.php << 'EOF'
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        // Redirection vers le dashboard admin
        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')).'|'.$request->ip();
    }
}
EOF

# 2. Corriger le fichier de routes admin pour définir une route par défaut
echo "🛣️ Mise à jour des routes admin..."
# Ajouter au début du fichier routes/admin.php après le groupe
sed -i '/Route::middleware.*admin.*group(function/a\    // Redirection par défaut vers dashboard\n    Route::get('\''/'\'', function() { return redirect()->route('\''admin.dashboard'\''); });' routes/admin.php

# 3. Créer un middleware pour vérifier le rôle et rediriger
echo "🔐 Création du middleware AdminRedirect..."
cat > app/Http/Middleware/AdminRedirect.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            // Si on accède à /admin sans route spécifique, rediriger vers dashboard
            if ($request->is('admin') && !$request->is('admin/*')) {
                return redirect()->route('admin.dashboard');
            }
        }
        
        return $next($request);
    }
}
EOF

# 4. Enregistrer le middleware
echo "📝 Enregistrement du middleware..."
# Ajouter le middleware dans app/Http/Kernel.php ou bootstrap/app.php selon la version

# Pour Laravel 11+, modifier bootstrap/app.php
if [ -f "bootstrap/app.php" ]; then
    echo "// Ajoutez ceci dans le middleware alias de bootstrap/app.php"
    echo "'admin.redirect' => \App\Http\Middleware\AdminRedirect::class,"
fi

# 5. Créer/Vérifier le HomeController pour la redirection initiale
echo "🏠 Création du HomeController..."
cat > app/Http/Controllers/HomeController.php << 'EOF'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('login');
    }
}
EOF

# 6. Mettre à jour routes/web.php
echo "🛣️ Mise à jour de la route racine..."
cat > routes/web.php << 'EOF'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes - STUDIOSUNISDB
|--------------------------------------------------------------------------
*/

// Redirection automatique selon l'état de connexion
Route::get('/', [HomeController::class, 'index'])->name('home');

// Inclure les routes d'authentification
require __DIR__.'/auth.php';

// Inclure les routes admin
require __DIR__.'/admin.php';

// Inclure les routes publiques
require __DIR__.'/public.php';

// Page 404 personnalisée
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
EOF

# 7. Corriger les permissions
echo "🔐 Correction des permissions..."
chown -R lalpha:www-data app/Http/Controllers/
chown -R lalpha:www-data app/Http/Middleware/
chmod -R 755 app/Http/Controllers/
chmod -R 755 app/Http/Middleware/

# 8. Vider les caches
echo "🧹 Nettoyage des caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

# 9. Redémarrer Apache
echo "🔄 Redémarrage d'Apache..."
sudo systemctl restart apache2

echo "✅ Correction terminée !"
echo ""
echo "📋 RÉSUMÉ DES CORRECTIONS :"
echo "- LoginController redirige maintenant vers admin.dashboard"
echo "- Route /admin redirige vers le dashboard"
echo "- Middleware de redirection créé"
echo "- Route racine / gérée correctement"
echo ""
echo "🔄 Déconnectez-vous et reconnectez-vous pour tester :"
echo "1. Cliquez sur 'Déconnexion'"
echo "2. Reconnectez-vous"
echo "3. Vous devriez arriver sur le dashboard"
