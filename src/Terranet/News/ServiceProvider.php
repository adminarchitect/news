<?php

namespace Terranet\News;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Terranet\News\Console\NewsTableCommand;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        if (! defined('_TERRANET_NEWS_')) {
            define('_TERRANET_NEWS_', 1);
        }

        $baseDir = base_path("vendor/terranet/news");
        $this->publishes([$local = "{$baseDir}/publishes/routes.php" => $routes = app_path('Http/Terranet/News/routes.php')], 'routes');

        if (! $this->app->routesAreCached()) {
            if (file_exists($routes)) {
                /** @noinspection PhpIncludeInspection */
                require_once $routes;
            } else {
                /** @noinspection PhpIncludeInspection */
                require_once $local;
            }
        }
    }

    public function register()
    {
        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton('terranet.news', function ($app) {
            //
        });

        $this->app->singleton('command.news.table', function ($app) {
            return new NewsTableCommand($app['files'], $app['composer']);
        });

        $this->commands(['command.news.table']);
    }
}