<?php

namespace VeseluyRodjer\ServiceGenerator\Http\Providers;

use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use VeseluyRodjer\ServiceGenerator\Console\MakeController;
use VeseluyRodjer\ServiceGenerator\Console\MakeModel;

class CommandServiceProvider extends ArtisanServiceProvider
{
    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerModelMakeCommand()
    {
        $this->app->singleton('command.model.make', function ($app) {
            return new MakeModel($app['files']);
        });
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerControllerMakeCommand()
    {
        $this->app->singleton('command.controller.make', function ($app) {
            return new MakeController($app['files']);
        });
    }
}
