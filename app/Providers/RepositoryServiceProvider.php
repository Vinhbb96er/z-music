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
