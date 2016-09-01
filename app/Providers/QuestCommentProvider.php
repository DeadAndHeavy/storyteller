<?php

namespace App\Providers;

use App\Core\Service\QuestCommentService;
use Illuminate\Support\ServiceProvider;

class QuestCommentProvider extends ServiceProvider
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
        $this->app->singleton(QuestCommentService::class, function ($app) {
            return new QuestCommentService($app['request']);
        });
    }
}
