<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DebugAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Log::info('User accessing: ' . $request->path(), [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'ecole_id' => $user->ecole_id,
            ]);
        }
        
        return $next($request);
    }
}
