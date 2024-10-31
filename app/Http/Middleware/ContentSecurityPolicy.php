<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // public function handle($request, Closure $next)
    // {
    //     $response = $next($request);
    //     $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://trustedscripts.example.com; object-src 'none';");
    //     return $response;
    // }
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Set Content-Security-Policy header as a single line
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; style-src 'self' https://cdnjs.cloudflare.com https://cdn.jsdelivr.net; img-src 'self' data:;");

        // Additional security headers
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY'); // or 'SAMEORIGIN'
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        return $response;
    }
    

}
