<?php

namespace Terranet\News\Models;

use Codesleeve\Stapler\ORM\EloquentTrait as StaplerableTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model implements StaplerableInterface
{
    use StaplerableTrait;

    protected $table = 'news_items';

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'image', 'status',
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
}
