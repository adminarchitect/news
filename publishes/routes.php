<?php

Route::group(['namespace' => 'Laravel\News'], function () {
    Route::get('news', [
        'as' => 'news.list',
        'uses' => 'NewsController@index',
    ]);

    Route::get('news/:slug.html', [
        'as' => 'news.show',
        'uses' => 'NewsController@show',
    ]);
});