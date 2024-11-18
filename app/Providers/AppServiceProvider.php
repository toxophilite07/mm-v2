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
    public function register()
    {
        $this->app->singleton(Client::class, function () {
            return \OpenAI::client(env('OPENAI_API_KEY'), [
                'http_client' => [
                    'verify' => false,  // Disable SSL verification (you may want to handle SSL verification in a more secure way)
                ],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production environment
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Prevent non-browser requests (like curl) from accessing the application
        if (str_contains(request()->header('User-Agent'), 'curl')) {
            abort(403, 'Forbidden');
        }

        // Secure headers for added protection
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
