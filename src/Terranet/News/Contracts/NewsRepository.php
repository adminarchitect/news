<?php

namespace Terranet\News\Contracts;

interface NewsRepository
{
    public function recent($page = 1);

    public function findBySlug($slug);

    public function findByCategory($slug, $page = 1);
}