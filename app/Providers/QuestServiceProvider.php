<?php

namespace App\Providers;

use App\Core\Service\QuestService;
use Illuminate\Support\Facades\Validator;
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
        Validator::extend('valid_genre',
            function ($attribute, $value, $parameters)
            {
                return array_key_exists($value, QuestService::getAllQuestGenres());
            },
            'Bad genre'
        );
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
