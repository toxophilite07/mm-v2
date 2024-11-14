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
        // Register OpenAI client (if required)
        $this->app->singleton(Client::class, function () {
            return \OpenAI::client(env('OPENAI_API_KEY'), [
                'http_client' => [
                    'verify' => false,  // Disable SSL verification (use cautiously in production)
                ],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ensure secure headers are applied globally for all responses
        $this->applySecureHeaders();

        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Set default string length for database schemas
        Schema::defaultStringLength(191);
    }

    /**
     * Apply security headers to all responses.
     */
    protected function applySecureHeaders()
    {
        // Add a response macro to include secure headers
        Response::macro('secureHeaders', function ($content) {
            return response($content)
                ->header('X-Content-Type-Options', 'nosniff')
                ->header('X-Frame-Options', 'DENY')
                ->header('X-XSS-Protection', '1; mode=block')
                ->header('Referrer-Policy', 'no-referrer')
                ->header('Strict-Transport-Security', 'max-age=31536000; includeSubDomains')
                ->header('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; object-src 'none'; base-uri 'self';");
        });

        // Apply the macro to all responses globally
        \Illuminate\Support\Facades\Response::macro('sendSecureResponse', function ($content) {
            return \response($content)->secureHeaders();
        });
    }
}
