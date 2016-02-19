<?php

namespace Terranet\News\Models;

use App\NewsItem as AppNewsItem;
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

    protected $appends = ['url'];

    public function news()
    {
        return $this->belongsToMany(
            AppNewsItem::class,
            'news_category_items'
        );
    }

    /**
     * @return mixed
     */
    public function getUrlAttribute()
    {
        return $this->route();
    }

    public function route()
    {
        return route('news.category', ['slug' => $this->getSlug()]);
    }
}
