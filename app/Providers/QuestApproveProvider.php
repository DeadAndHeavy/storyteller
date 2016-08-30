<?php

namespace App\Providers;

use App\Core\Service\QuestApproveService;
use Illuminate\Support\ServiceProvider;

class QuestApproveProvider extends ServiceProvider
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
        $this->app->singleton(QuestApproveService::class, function ($app) {
            return new QuestApproveService($app['request']);
        });
    }
}
