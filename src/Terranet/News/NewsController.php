<?php

namespace Terranet\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * List recent news
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        
        return news()->recent($page);
    }

    /**
     * Show news item
     *
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        return news()->findBySlug($slug);
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

        return news()->findByCategory($slug, $page);
    }
}