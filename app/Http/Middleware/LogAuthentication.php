<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        // Pour l'instant, juste passer la requête
        // Vous pourrez ajouter la logique de log plus tard
        return $next($request);
    }
}
