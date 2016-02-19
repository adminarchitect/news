<?php

namespace Terranet\News;

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

    public function setPerPage($perPage)
    {
        $this->perPage = (int) $perPage;

        return $this;
    }

    public function recent($page = 1)
    {
        return $this->newsModel->orderBy('created_at', 'desc')->forPage($page)->take($this->perPage)->get();
    }

    public function findBySlug($slug)
    {
        return $this->newsModel->with('categories')->whereSlug($slug)->first();
    }

    public function findByCategory($slug, $page = 1)
    {
        $category = $this->categoriesModel->whereSlug($slug)->first();

        return $category->news()->with('categories')->orderBy('created_at', 'desc')->forPage($page)->take($this->perPage)->get();
    }

    protected function createModel($class)
    {
        return new $class;
    }
}
