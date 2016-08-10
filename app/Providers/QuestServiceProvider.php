<?php

namespace App\Providers;

use App\Core\Service\QuestService;
use Illuminate\Support\ServiceProvider;

class QuestServiceProvider extends ServiceProvider
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
        $this->app->singleton(QuestService::class, function ($app) {
            return new QuestService($app['request']);
        });
    }
}
