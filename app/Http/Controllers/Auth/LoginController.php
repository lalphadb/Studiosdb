<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validation renforcée
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'L\'adresse courriel est requise.',
            'email.email' => 'L\'adresse courriel doit être valide.',
            'email.max' => 'L\'adresse courriel ne peut pas dépasser 255 caractères.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Rate limiting par IP (10 tentatives par 15 minutes)
        $ipKey = 'login-ip:' . $request->ip();
        if (RateLimiter::tooManyAttempts($ipKey, 10)) {
            $seconds = RateLimiter::availableIn($ipKey);
            return redirect()->back()
                ->withErrors(['email' => "Trop de tentatives depuis cette adresse IP. Réessayez dans " . ceil($seconds / 60) . " minute(s)."])
                ->withInput($request->only('email'));
        }

        // Rate limiting par email (5 tentatives par 15 minutes)
        $emailKey = 'login-email:' . strtolower($request->email);
        if (RateLimiter::tooManyAttempts($emailKey, 5)) {
            $seconds = RateLimiter::availableIn($emailKey);
            return redirect()->back()
                ->withErrors(['email' => "Trop de tentatives pour cet email. Réessayez dans " . ceil($seconds / 60) . " minute(s)."])
                ->withInput($request->only('email'));
        }

        // Vérifier si l'utilisateur existe
        $user = User::where('email', $request->email)->first();
        
        if ($user) {
            // Vérifier si le compte est verrouillé
            if ($user->is_locked) {
                return redirect()->back()
                    ->withErrors(['email' => 'Votre compte est temporairement verrouillé suite à trop de tentatives de connexion. Réessayez plus tard.'])
                    ->withInput($request->only('email'));
            }

            // Vérifier si le compte est actif
            if (!$user->active) {
                Log::warning('Tentative de connexion sur compte désactivé', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                ]);
                
                return redirect()->back()
                    ->withErrors(['email' => 'Votre compte est désactivé. Contactez l\'administrateur.'])
                    ->withInput($request->only('email'));
            }
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Tentative de connexion
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Réinitialiser les tentatives et mettre à jour les infos
            $user->resetLoginAttempts();
            $user->updateLoginInfo($request);

            // Clear rate limiting
            RateLimiter::clear($ipKey);
            RateLimiter::clear($emailKey);

            // Log de connexion réussie
            Log::info('Connexion réussie', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Message de bienvenue personnalisé
            $welcomeMessage = $this->getWelcomeMessage($user);
            session()->flash('success', $welcomeMessage);

            // Redirection selon le rôle
            return $this->redirectByRole($user);
        }

        // Connexion échouée
        if ($user) {
            $user->incrementLoginAttempts();
            
            Log::warning('Échec de connexion - Mot de passe incorrect', [
                'user_id' => $user->id,
                'email' => $request->email,
                'ip' => $request->ip(),
                'attempts' => $user->login_attempts + 1,
            ]);
        } else {
            Log::warning('Échec de connexion - Email inexistant', [
                'email' => $request->email,
                'ip' => $request->ip(),
            ]);
        }

        // Incrémenter les rate limiters
        RateLimiter::hit($ipKey, 900); // 15 minutes
        RateLimiter::hit($emailKey, 900); // 15 minutes

        return redirect()->back()
            ->withErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.'])
            ->withInput($request->only('email'));
    }

    protected function getWelcomeMessage($user)
    {
        $greeting = $this->getTimeBasedGreeting();
        $lastLogin = $user->last_login_at ? 
            "Dernière connexion : " . $user->last_login_at->diffForHumans() : 
            "Bienvenue pour votre première connexion !";

        return "{$greeting} {$user->full_name} ! {$lastLogin}";
    }

    protected function getTimeBasedGreeting()
    {
        $hour = now()->hour;
        
        if ($hour < 12) {
            return "Bonjour";
        } elseif ($hour < 18) {
            return "Bon après-midi";
        } else {
            return "Bonsoir";
        }
    }

    protected function redirectByRole($user)
    {
        $roleMessages = [
            'superadmin' => '🔧 Accès Super Administrateur activé - Tous les pouvoirs débloqués',
            'admin' => '⚡ Tableau de bord Administrateur - Gestion complète de votre école',
            'instructeur' => '🥋 Espace Instructeur - Gérez vos cours et élèves',
            'membre' => '👋 Espace Membre - Bienvenue dans votre espace personnel',
        ];

        $message = $roleMessages[$user->role] ?? 'Bienvenue dans votre espace';
        
        return redirect()->intended('/admin/dashboard')->with('role_message', $message);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            Log::info('Déconnexion utilisateur', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'session_duration' => $user->last_login_at ? 
                    now()->diffInMinutes($user->last_login_at) . ' minutes' : 'inconnu',
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('status', 'Vous avez été déconnecté avec succès. À bientôt !');
    }
}
