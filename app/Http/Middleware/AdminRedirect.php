<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            // Si on accède à /admin sans route spécifique, rediriger vers dashboard
            if ($request->is('admin') && ! $request->is('admin/*')) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}
