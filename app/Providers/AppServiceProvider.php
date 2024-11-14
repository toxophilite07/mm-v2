<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use OpenAI\Client;
use Illuminate\Support\Facades\Response; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    //ORGINAL INI SYA//
    // public function register()
    // {
    //     $this->app->singleton(Client::class, function () {
    //         return \OpenAI::client(env('OPENAI_API_KEY'), [
    //             'http_client' => [
    //                 'verify' => false,  // Disable SSL verification
    //             ],
    //         ]);
    //     });
    // }

    // /**
    //  * Bootstrap any application services.
    //  */
    // public function boot(): void
    // {
    //     Schema::defaultStringLength(191);
    // }

    //MODIFY INI SYA//
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return \OpenAI::client(env('OPENAI_API_KEY'), [
                'http_client' => [
                    'verify' => false,  // Disable SSL verification
                ],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Check if the request is coming from a non-browser (like curl)
        if (str_contains(request()->header('User-Agent'), 'curl')) {
            abort(403, 'Forbidden');
        }
    
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    
        // Define secure headers macro
        Response::macro('secureHeaders', function ($content) {
            return response($content)
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-Frame-Options', 'DENY')
                ->header('X-XSS-Protection', '1; mode=block')
                ->header('Referrer-Policy', 'no-referrer')
                ->header('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; object-src 'none'; base-uri 'self';");
        });
    }
    

}
