<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // En développement local : CSP permissif pour Vite
        if (app()->environment('local', 'testing')) {
            $viteHost = 'http://127.0.0.1:5173';
            $policies = [
                "default-src 'self' {$viteHost}",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' {$viteHost} blob:",
                "script-src-elem 'self' 'unsafe-inline' {$viteHost}",
                "style-src 'self' 'unsafe-inline' {$viteHost} https://fonts.googleapis.com",
                "style-src-elem 'self' 'unsafe-inline' {$viteHost} https://fonts.googleapis.com",
                "font-src 'self' https://fonts.gstatic.com data:",
                "img-src 'self' data: https: {$viteHost}",
                "connect-src 'self' {$viteHost} ws://127.0.0.1:5173 wss://127.0.0.1:5173",
                "worker-src 'self' blob:",
                "child-src 'self' blob:",
                "frame-src 'self'",
                "media-src 'self' {$viteHost}",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'"
            ];
        } else {
            // Production : CSP strict
            $policies = [
                "default-src 'self'",
                "script-src 'self'",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
                "font-src 'self' https://fonts.gstatic.com",
                "img-src 'self' data: https:",
                "connect-src 'self'",
                "worker-src 'self'",
                "child-src 'none'",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'none'",
                "upgrade-insecure-requests"
            ];
        }
        
        $csp = implode('; ', $policies);
        $response->headers->set('Content-Security-Policy', $csp);
        
        return $response;
    }
}
