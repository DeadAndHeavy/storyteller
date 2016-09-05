<?php

namespace App\Providers;

use App\Core\Service\WebSocketService;
use Illuminate\Support\ServiceProvider;

class WebSocketProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WebSocketService::class, function ($app) {
            return new WebSocketService($app['request']);
        });
    }
}
