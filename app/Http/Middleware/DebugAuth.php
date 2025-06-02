<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DebugAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            Log::info('User authenticated', [
                'user_id' => auth()->id(),
                'email' => auth()->user()->email,
                'active' => auth()->user()->active,
                'role' => auth()->user()->role,
            ]);
        } else {
            Log::info('No authenticated user');
        }

        return $next($request);
    }
}
