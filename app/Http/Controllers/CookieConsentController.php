<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie; // Add this import for the Cookie facade

class CookieConsentController extends Controller
{
    public function acceptConsent(Request $request)
    {
        // Set the cookie to remember the consent
        Cookie::queue('cookie_consent', 'accepted', 365); // Cookie valid for 1 year

        // Redirect back or to a specific page
        return redirect()->back()->with('message', 'Cookie consent accepted!');
    }
}
