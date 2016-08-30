<?php

namespace App\Providers;

use App\Core\Service\VoteService;
use Illuminate\Support\ServiceProvider;

class VoteProvider extends ServiceProvider
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
        $this->app->singleton(VoteService::class, function ($app) {
            return new VoteService($app['request']);
        });
    }
}
