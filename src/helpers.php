<?php

use Terranet\News\Contracts\NewsRepository;

if (! function_exists('news')) {
    /**
     * Get the news repository instance
     *
     * @return NewsRepository
     */
    function news()
    {
        return app()->make(NewsRepository::class);
    }
}