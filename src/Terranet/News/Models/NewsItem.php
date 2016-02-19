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
        'title', 'slug', 'image', 'excerpt', 'body', 'status',
    ];

    protected $appends = ['url', 'images'];

    protected $hidden = ['image_file_name', 'image_file_size', 'image_content_type', 'image_updated_at'];

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

    public function linkToRoute()
    {
        return link_to_route('news.show', $this->title, ['slug' => $this->getSlug()]);
    }

    public function getImagesAttribute()
    {
        return array_build($this->image->getConfig()->styles, function ($index, $style) {
            if (! $size = $style->dimensions) {
                list($w, $h) = getimagesize($this->image->path());

                $size = "{$w}x{$h}";
            }

            return [
                $style->name,
                [
                    'url' => $this->image->url($style->name),
                    'name' => $this->attributes['image_file_name'],
                    'dimensions' => $size,
                    'type' => $this->attributes['image_content_type'],
                ],
            ];
        });
    }

    public function getUrlAttribute($value = null)
    {
        return $this->route();
    }

    public function route()
    {
        return route('news.show', ['slug' => $this->getSlug()]);
    }
}
