<?php

namespace Terranet\News;

use App\NewsCategory;
use App\NewsItem;
use Cviebrock\EloquentSluggable\SluggableServiceProvider;
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
        $local = "{$baseDir}/publishes/routes.php";
        $routes = app_path('Http/Terranet/News/routes.php');

        if (! $this->app->routesAreCached()) {
            if (file_exists($routes)) {
                /** @noinspection PhpIncludeInspection */
                require_once $routes;
            } else {
                /** @noinspection PhpIncludeInspection */
                require_once $local;
            }
        }

        // routes
        $this->publishes([$local => $routes], 'routes');

        // resources
        $this->publishes(["{$baseDir}/publishes/Modules" => app_path('Http/Terranet/Administrator/Modules')], 'resources');

        // models
        $this->publishes(["{$baseDir}/publishes/Models" => app_path()], 'models');
    }

    public function register()
    {
        $this->app->register(SluggableServiceProvider::class);

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton('Terranet\News\Contracts\NewsRepository', function () {
            return new NewsRepository(NewsItem::class, NewsCategory::class);
        });

        $this->app->singleton('command.news.table', function ($app) {
            return new NewsTableCommand($app['files'], $app['composer']);
        });

        $this->commands(['command.news.table']);
    }
}