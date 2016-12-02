<?php

namespace App\Providers;

use App\Core\Service\QuestLogicService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class QuestLogicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('valid_quest_variable_type',
            function ($attribute, $value, $parameters)
            {
                return array_key_exists($value, QuestLogicService::getAllVariableTypes());
            },
            'Bad quest variable type'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(QuestLogicService::class, function ($app) {
            return new QuestLogicService($app['request']);
        });
    }
}
