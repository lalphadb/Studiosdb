#!/bin/bash
# check_middlewares.sh

echo "Vérification des middlewares..."

middlewares=(
    "app/Http/Middleware/TrustProxies.php"
    "app/Http/Middleware/PreventRequestsDuringMaintenance.php"
    "app/Http/Middleware/TrimStrings.php"
    "app/Http/Middleware/EncryptCookies.php"
    "app/Http/Middleware/VerifyCsrfToken.php"
    "app/Http/Middleware/SecurityHeaders.php"
    "app/Http/Middleware/Authenticate.php"
    "app/Http/Middleware/RedirectIfAuthenticated.php"
    "app/Http/Middleware/EnsureUserIsActive.php"
    "app/Http/Middleware/RoleMiddleware.php"
    "app/Http/Middleware/DebugAuth.php"
)

for middleware in "${middlewares[@]}"; do
    if [ -f "$middleware" ]; then
        echo "✅ $middleware existe"
    else
        echo "❌ $middleware MANQUANT"
    fi
done
