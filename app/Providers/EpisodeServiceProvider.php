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
        Validator::extend('valid_episode_type',
            function ($attribute, $value, $parameters)
            {
                return array_key_exists($value, EpisodeService::getAllEpisodeTypes());
            },
            'Bad episode type'
        );

        Validator::extend('unique_episode_type',
            function ($attribute, $value, $parameters)
            {
                if ($parameters[0] != EpisodeService::EPISODE_TYPE_START) {
                    return true;
                }
                $startEpisode = EpisodeService::getStartEpisode($parameters[1]);
                return  is_null($startEpisode) || (!is_null($startEpisode) && $parameters[2] && $startEpisode->id == $parameters[2]);
            },
            'Episode with this type already exists'
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
