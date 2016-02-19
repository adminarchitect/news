<?php

namespace Terranet\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Terranet\News\Contracts\NewsRepository;

class NewsController extends Controller
{
    /**
     * @var NewsRepository
     */
    protected $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List recent news
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);

        return $this->repository->recent($page);
    }

    /**
     * Show news item
     *
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        return $this->repository->findBySlug($slug);
    }

    /**
     * List news by category
     *
     * @param $slug
     * @param Request $request
     * @return mixed
     */
    public function category($slug, Request $request)
    {
        $page = $request->get('page', 1);

        return $this->repository->findByCategory($slug, $page);
    }
}