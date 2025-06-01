<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté et actif
        if (Auth::check() && !Auth::user()->active) {
            Auth::logout();
            
            return redirect()->route('login')
                ->with('error', 'Votre compte est inactif. Veuillez contacter l\'administrateur.');
        }

        return $next($request);
    }
}
