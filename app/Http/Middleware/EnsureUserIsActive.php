<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté et actif
        if (Auth::check()) {
            $user = Auth::user();
            
            if (!$user->active) {
                // Logger la déconnexion forcée
                activity()
                    ->causedBy($user)
                    ->event('forced_logout')
                    ->withProperties(['reason' => 'inactive_account'])
                    ->log('Utilisateur déconnecté - compte inactif');
                
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('error', 'Votre compte est inactif. Veuillez contacter l\'administrateur.');
            }
        }

        return $next($request);
    }
}
