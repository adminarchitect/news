<?php

namespace Terranet\News;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        if (! defined('_TERRANET_NEWS_')) {
            define('_TERRANET_NEWS_', 1);
        }

        $baseDir = base_path("vendor/laravel/news");
        $this->publishes(["{$baseDir}/src/routes.php" => $routes = app_path('Http/Laravel/News/routes.php')], 'routes');

        if (! $this->app->routesAreCached()) {
            if (file_exists($routes)) {
                /** @noinspection PhpIncludeInspection */
                require_once $routes;
            } else {
                /** @noinspection PhpIncludeInspection */
                require_once "{$baseDir}/src/routes.php";
            }
        }
    }

    public function register()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton('terranet.options', function ($app) {
            return new Manager($app);
        });

        $this->app->singleton('command.options.table', function ($app) {
            return new OptionsTableCommand($app['files'], $app['composer']);
        });

        $this->app->singleton('command.options.make', function ($app) {
            return new OptionMakeCommand($app['files'], $app['composer']);
        });

        $this->app->singleton('command.options.remove', function ($app) {
            return new OptionRemoveCommand($app['files'], $app['composer']);
        });

        $this->commands(['command.options.table', 'command.options.make', 'command.options.remove']);
    }
}