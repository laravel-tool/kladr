<?php

namespace LaravelTool\Kladr;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelTool\Kladr\Console\UpdateCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__."/../config/kladr.php", 'kladr'
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        $this->publishes(
            [
                __DIR__."/../config/kladr.php" => config_path('kladr.php'),
            ]
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                UpdateCommand::class,
            ]);
        }
    }
}
