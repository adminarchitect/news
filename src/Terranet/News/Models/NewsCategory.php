<?php

namespace Terranet\News\Models;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model implements SluggableInterface
{
    use SluggableTrait;

    public $timestamps = false;

    protected $table = 'news_categories';

    protected $fillable = ['title', 'slug'];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'on_update' => true,
    ];
}
