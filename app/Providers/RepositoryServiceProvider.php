<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Media\MediaInterface',
            'App\Repositories\Media\MediaRepository'
        );

        $this->app->bind(
            'App\Repositories\Album\AlbumInterface',
            'App\Repositories\Album\AlbumRepository'
        );

        $this->app->bind(
            'App\Repositories\Region\RegionInterface',
            'App\Repositories\Region\RegionRepository'
        );

        $this->app->bind(
            'App\Repositories\Kind\KindInterface',
            'App\Repositories\Kind\KindRepository'
        );

        $this->app->bind(
            'App\Repositories\User\UserInterface',
            'App\Repositories\User\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\Tag\TagInterface',
            'App\Repositories\Tag\TagRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
