<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; // Add this import for the Cookie facade
use Symfony\Component\HttpFoundation\Response;

class CookieConsent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the cookie consent is accepted
        if (!$request->hasCookie('cookie_consent')) {
            // Show the cookie consent banner
            session()->flash('show_cookie_consent', true);
        }

        return $next($request);
    }

    public function acceptConsent(Request $request)
    {
        // Set the cookie to remember the consent
        Cookie::queue('cookie_consent', 'accepted', 365); // Cookie valid for 1 year

        // Redirect back or to a specific page
        return redirect()->back()->with('message', 'Cookie consent accepted!');
    }
}
