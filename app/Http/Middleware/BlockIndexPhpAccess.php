<?php
namespace App\Http\Middleware;

use Closure;

class BlockIndexPhpAccess
{
    public function handle($request, Closure $next)
    {
        // Check if the request contains 'index.php'
        if (strpos($request->getRequestUri(), 'index.php') !== false) {
            // Redirect to the same route without 'index.php'
            return redirect()->to(str_replace('index.php', '', $request->getRequestUri()));
        }

        return $next($request);
    }
}
