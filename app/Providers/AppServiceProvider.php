<?php

namespace App\Providers;

use GuzzleHttp\Client;
use App\Interfaces\AsyncClientInterface;
use App\Models\AsyncClient;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AsyncClientInterface::class, function () {
            return new AsyncClient([
                'base_uri' => 'http://proxycheck.io/v2/',
                'request.options' => [
                    'timeout' => 3,
                    'connect_timeout' => 3, 
                ],
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
