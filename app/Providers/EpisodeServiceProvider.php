<?php

namespace App\Providers;

use App\Core\Service\EpisodeService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class EpisodeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('valid_episode_actions_count',
            function ($attribute, $value, $parameters)
            {
                return count($value) > 1;
            },
            'you need to add at least one action'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EpisodeService::class, function ($app) {
            return new EpisodeService($app['request']);
        });
    }
}
