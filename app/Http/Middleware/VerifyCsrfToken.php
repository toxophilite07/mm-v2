<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'webhook-endpoint', // Example endpoint that should bypass CSRF
        'api/*',            // Exclude all API routes if you're handling CSRF differently
    ];

    // public function handle($request, Closure $next)
    // {
    //     return $next($request)
    //         ->header('Content-Security-Policy', "default-src 'self'; img-src 'self' data:; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';");
    // }
}
