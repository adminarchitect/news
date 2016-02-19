<?php

Route::group([
    'prefix' => 'news',
    'namespace' => 'Terranet\News',
], function () {
    Route::get('/', [
        'as' => 'news.list',
        'uses' => 'NewsController@index',
    ]);

    Route::get('{slug}.html', [
        'as' => 'news.show',
        'uses' => 'NewsController@show',
    ]);

    Route::get('{slug}', [
        'as' => 'news.category',
        'uses' => 'NewsController@category',
    ]);
});