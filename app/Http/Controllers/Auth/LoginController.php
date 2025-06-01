<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Log l'activité si spatie/laravel-activitylog est installé
        if (class_exists(\Spatie\Activitylog\Models\Activity::class)) {
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['ip' => $request->ip()])
                ->log('Connexion réussie');
        }

        // Redirection selon le rôle
        return $this->redirectBasedOnRole();
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log l'activité si spatie/laravel-activitylog est installé
        if (auth()->check() && class_exists(\Spatie\Activitylog\Models\Activity::class)) {
            activity()
                ->causedBy(auth()->user())
                ->log('Déconnexion');
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirection basée sur le rôle de l'utilisateur
     */
    protected function redirectBasedOnRole(): RedirectResponse
    {
        $user = auth()->user();
        
        if ($user->hasRole(['super-admin', 'admin'])) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->hasRole('instructeur')) {
            return redirect()->intended(route('admin.cours.index'));
        } else {
            // Pour les membres réguliers
            if ($user->membre) {
                return redirect()->intended(route('admin.membres.show', $user->membre->id));
            }
            return redirect()->intended(route('admin.dashboard'));
        }
    }

    /**
     * Reset login attempts (pour LoginRequest)
     */
    public function resetLoginAttempts(Request $request): void
    {
        $key = $this->throttleKey($request);
        cache()->forget($key);
    }

    /**
     * Get the throttle key
     */
    protected function throttleKey(Request $request): string
    {
        return strtolower($request->input('email')).'|'.$request->ip();
    }
}
