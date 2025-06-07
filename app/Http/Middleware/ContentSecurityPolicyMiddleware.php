<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicyMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        // Configuration CSP selon l'environnement
        $csp = $this->buildContentSecurityPolicy();
        
        $response->headers->set('Content-Security-Policy', $csp);
        
        return $response;
    }
    
    /**
     * Build Content Security Policy based on environment
     */
    private function buildContentSecurityPolicy(): string
    {
        $isLocal = app()->environment('local', 'testing');
        $viteDevServer = 'http://127.0.0.1:5173';
        
        $policies = [
            'default-src' => ["'self'"],
            'script-src' => $this->getScriptSrc($isLocal, $viteDevServer),
            'style-src' => $this->getStyleSrc($isLocal, $viteDevServer),
            'img-src' => ["'self'", 'data:', 'https:'],
            'font-src' => ["'self'", 'https://fonts.gstatic.com'],
            'connect-src' => $this->getConnectSrc($isLocal, $viteDevServer),
            'media-src' => ["'self'"],
            'object-src' => ["'none'"],
            'base-uri' => ["'self'"],
            'form-action' => ["'self'"],
            'frame-ancestors' => ["'none'"],
            'upgrade-insecure-requests' => $isLocal ? [] : [''],
        ];
        
        return $this->compilePolicies($policies);
    }
    
    /**
     * Get script-src directives
     */
    private function getScriptSrc(bool $isLocal, string $viteDevServer): array
    {
        $sources = ["'self'"];
        
        if ($isLocal) {
            // En développement : autoriser Vite
            $sources[] = $viteDevServer;
            $sources[] = "'unsafe-eval'"; // Nécessaire pour Vite HMR
        }
        
        // Autoriser les scripts inline pour les pages auth (toggle password)
        if (request()->routeIs('login', 'register', 'password.*')) {
            $sources[] = "'unsafe-inline'";
        }
        
        return $sources;
    }
    
    /**
     * Get style-src directives  
     */
    private function getStyleSrc(bool $isLocal, string $viteDevServer): array
    {
        $sources = ["'self'", "'unsafe-inline'", 'https://fonts.googleapis.com'];
        
        if ($isLocal) {
            $sources[] = $viteDevServer;
        }
        
        return $sources;
    }
    
    /**
     * Get connect-src directives
     */
    private function getConnectSrc(bool $isLocal, string $viteDevServer): array
    {
        $sources = ["'self'"];
        
        if ($isLocal) {
            // WebSocket pour Vite HMR
            $sources[] = 'ws://127.0.0.1:5173';
            $sources[] = $viteDevServer;
        }
        
        return $sources;
    }
    
    /**
     * Compile policies into CSP string
     */
    private function compilePolicies(array $policies): string
    {
        $csp = [];
        
        foreach ($policies as $directive => $sources) {
            if (empty($sources)) {
                continue;
            }
            
            if ($directive === 'upgrade-insecure-requests' && !empty($sources)) {
                $csp[] = $directive;
            } else {
                $csp[] = $directive . ' ' . implode(' ', $sources);
            }
        }
        
        return implode('; ', $csp);
    }
}
