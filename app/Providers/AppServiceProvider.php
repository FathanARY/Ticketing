<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        // Fix SSL certificate issue for Guzzle/cURL on Windows (Laragon/AMPPS)
        if (config('app.env') === 'local') {
            $certPath = storage_path('cacert.pem');
            if (file_exists($certPath)) {
                // Set for Guzzle HTTP client
                $this->app->bind(\GuzzleHttp\Client::class, function () use ($certPath) {
                    return new \GuzzleHttp\Client([
                        'verify' => $certPath,
                    ]);
                });
            }
        }
    }
}
