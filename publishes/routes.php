<?php

Route::group([
    'prefix' => 'news',
    'namespace' => 'Laravel\News'
], function () {
    Route::get('/', [
        'as' => 'news.list',
        'uses' => 'NewsController@index',
    ]);

    Route::get('{slug}.html', [
        'as' => 'news.show',
        'uses' => 'NewsController@show',
    ]);
});