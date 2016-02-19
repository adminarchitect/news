<?php

namespace Terranet\News;

use App\NewsCategory;
use App\NewsItem;
use Illuminate\Database\Eloquent\Collection;
use Terranet\News\Contracts\NewsRepository as NewsContract;

class NewsRepository implements NewsContract
{
    protected $newsModel;

    protected $categoriesModel;

    protected $perPage = 10;

    public function __construct($newsModel, $categoriesModel)
    {
        $this->newsModel = $this->createModel($newsModel);

        $this->categoriesModel = $this->createModel($categoriesModel);
    }

    /**
     * Create model
     *
     * @param $class
     * @return mixed
     */
    protected function createModel($class)
    {
        if (is_string($class))
            $class = new $class;

        return $class;
    }

    /**
     * Set number of fetched items
     *
     * @param $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        return $this;
    }

    /**
     * Fetch news in descending order
     *
     * @param int $page
     * @return Collection
     */
    public function recent($page = 1)
    {
        return $this->newsModel
            ->take($this->perPage)
            ->forPage($page)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Find news by unique identifier
     *
     * @param $slug
     * @return NewsItem
     */
    public function findBySlug($slug)
    {
        return $this->newsModel
            ->with('categories')
            ->whereSlug($slug)
            ->first();
    }

    /**
     * Find news by category identifier
     *
     * @param $slug
     * @param int $page
     * @return Collection
     */
    public function findByCategory($slug, $page = 1)
    {
        if ($category = $this->fetchCategory($slug)) {
            return $category->news()
                ->with('categories')
                ->take($this->perPage)
                ->forPage($page)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return Collection::make([]);
    }

    /**
     * Fetch category by identifier
     *
     * @param $slug
     * @return NewsCategory
     */
    protected function fetchCategory($slug)
    {
        return $this->categoriesModel
            ->whereSlug($slug)
            ->first();
    }
}
