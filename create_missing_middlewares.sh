#!/bin/bash

echo "Création des middlewares manquants..."

# Créer le répertoire Middleware s'il n'existe pas
mkdir -p app/Http/Middleware

# PreventRequestsDuringMaintenance
cat > app/Http/Middleware/PreventRequestsDuringMaintenance.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    protected $except = [
        //
    ];
}
EOF

# TrimStrings
cat > app/Http/Middleware/TrimStrings.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
EOF

# EncryptCookies
cat > app/Http/Middleware/EncryptCookies.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    protected $except = [
        //
    ];
}
EOF

# VerifyCsrfToken
cat > app/Http/Middleware/VerifyCsrfToken.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        //
    ];
}
EOF

# Authenticate
cat > app/Http/Middleware/Authenticate.php << 'EOF'
<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
EOF

# RedirectIfAuthenticated
cat > app/Http/Middleware/RedirectIfAuthenticated.php << 'EOF'
<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
EOF

echo "✅ Tous les middlewares ont été créés!"

# Vérifier à nouveau
echo -e "\nVérification finale:"
./check_middlewares.sh
