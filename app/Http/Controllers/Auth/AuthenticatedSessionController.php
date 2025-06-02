<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AuthLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
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
        // Log de tentative (Loi 25)
        AuthLog::create([
            'action' => 'login_attempt',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'additional_data' => json_encode(['email' => $request->email]),
        ]);

        $request->authenticate();

        $request->session()->regenerate();

        // Log de succès (Loi 25)
        AuthLog::create([
            'user_id' => auth()->id(),
            'action' => 'login_success',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Log de déconnexion (Loi 25)
        AuthLog::create([
            'user_id' => auth()->id(),
            'action' => 'logout',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
