<?php

namespace Terranet\News\Models;

use Codesleeve\Stapler\ORM\EloquentTrait as StaplerableTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model implements StaplerableInterface, SluggableInterface
{
    use StaplerableTrait, SluggableTrait;

    static public $statuses = [
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ];

    protected $table = 'news_items';

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'image', 'status',
    ];

    protected $sluggable = [
        'build_from' => 'title',
        'save_to' => 'slug',
        'on_update' => true,
    ];

    public function __construct($attributes = [])
    {
        $this->hasAttachedFile('image', [
            'styles' => [
                'thumb' => '250x80',
                'medium' => '300x300',
                'large' => '600x600',
            ],
        ]);

        parent::__construct($attributes);
    }

    /**
     * @widget
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class, 'news_category_items');
    }

    public function presentStatus()
    {
        $classes = [
            'draft' => 'bg-yellow',
            'published' => 'bg-green',
            'archived' => 'bg-gray',
        ];

        return \admin\output\label($s = $this->attributes['status'], $classes[$s]);
    }

    public function presentTitle()
    {
        return link_to_route(
            'news.show',
            $this->attributes['title'],
            ['slug' => $this->getSlug()],
            ['target' => '_blank']
        );
    }

    public function presentExcerpt()
    {
        return '<div class="well text-muted">' . $this->attributes['excerpt'] . '</div>';
    }

    public function presentBody()
    {
        return '<div class="well">' . $this->attributes['body'] . '</div>';
    }
}
