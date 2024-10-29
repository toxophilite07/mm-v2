<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
    
        // Content Security Policy (CSP)
        $csp = "default-src 'self'; ";
        $csp .= "script-src 'self' https://trusted-scripts.com; ";
        $csp .= "object-src 'none'; ";
        $csp .= "base-uri 'self';";
        $response->headers->set('Content-Security-Policy', $csp);
    
        // HTTP Security Headers
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
    
        return $response;
    }
}
