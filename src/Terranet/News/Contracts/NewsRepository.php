<?php

namespace Terranet\News\Contracts;

use App\NewsItem;
use Illuminate\Database\Eloquent\Collection;

interface NewsRepository
{
    /**
     * Fetch news in descending order
     *
     * @param int $page
     * @return Collection
     */
    public function recent($page = 1);

    /**
     * Find news by unique identifier
     *
     * @param $slug
     * @return NewsItem
     */
    public function findBySlug($slug);

    /**
     * Find news by category identifier
     *
     * @param $slug
     * @param int $page
     * @return Collection
     */
    public function findByCategory($slug, $page = 1);
}