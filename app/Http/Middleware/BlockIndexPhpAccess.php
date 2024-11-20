<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIndexPhpAccess
{
    public function handle($request, Closure $next)
    {
        $uri = $request->getRequestUri();
        
        // Log the requested URI for debugging
        Log::info("Requested URI: " . $uri);

        // Check if the request contains 'index.php'
        if (strpos($uri, 'index.php') !== false) {
            // Log that we're redirecting
            Log::info("Redirecting from: " . $uri);

            // Redirect to the same route without 'index.php'
            return redirect()->to(str_replace('index.php', '', $uri));
        }

        return $next($request);
    }
}
