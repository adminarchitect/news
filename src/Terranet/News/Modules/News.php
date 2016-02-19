<?php

namespace Terranet\News\Modules;

use App\NewsCategory;
use App\NewsItem;
use App\NewsItemCategory;
use Terranet\Administrator\Contracts\Module\Editable;
use Terranet\Administrator\Contracts\Module\Exportable;
use Terranet\Administrator\Contracts\Module\Filtrable;
use Terranet\Administrator\Contracts\Module\Navigable;
use Terranet\Administrator\Contracts\Module\Sortable;
use Terranet\Administrator\Contracts\Module\Validable;
use Terranet\Administrator\Resource;
use Terranet\Administrator\Traits\Module\AllowFormats;
use Terranet\Administrator\Traits\Module\HasFilters;
use Terranet\Administrator\Traits\Module\HasForm;
use Terranet\Administrator\Traits\Module\HasSortable;
use Terranet\Administrator\Traits\Module\ValidatesForm;

/**
 * Administrator Resource News
 *
 * @package Terranet\Administrator
 */
class News extends Resource implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats;

    /**
     * The module Eloquent model
     *
     * @var string
     */
    protected $model = NewsItem::class;
    protected $magnetParams = ['news_category_id'];

    /**
     * Module title
     *
     * @return string
     */
    public function title()
    {
        return "List news";
    }

    /**
     * Navigation group
     *
     * @return string
     */
    public function group()
    {
        return "News";
    }

    /**
     * Validation rules
     *
     * @return mixed
     */
    public function rules()
    {
        return array_except($this->scaffoldRules(), ['slug']);
    }

    /**
     * News form
     *
     * @return mixed
     */
    public function form()
    {
        return array_merge(
            array_except($this->scaffoldForm(), ['slug']),
            [
                'status' => [
                    'type' => 'select',
                    'options' => NewsItem::$statuses,
                ],
                'news_category_id' => [
                    'label' => 'Belongs to',
                    'type' => 'select',
                    'options' => function () {
                        return ['' => '-- Select --'] + NewsCategory::lists('title', 'id')->toArray();
                    },
                    'multiple' => true,
                    'relation' => 'categories',
                ],
                'body' => [
                    'type' => 'tinymce',
                ],
            ]
        );
    }

    /**
     * News columns
     *
     * @return array
     */
    public function columns()
    {
        return
            [
                'id',
                'image' => ['output' => function ($row) {
                    return \admin\output\staplerImage($row->image);
                }],
                'info' => [
                    'elements' => [
                        'title' => ['standalone' => true],
                        'categories' => ['output' => function ($row) {
                            if ($cats = $row->categories) {
                                $cats = $cats->map(function ($cat) {
                                    return link_to($cat->route(), $cat->title);
                                });

                                return $cats->implode(', ');
                            }

                            return null;
                        }],
                    ],
                ],
                'excerpt',
                'status',
            ];
    }

    public function filters()
    {
        return [
            'title' => [
                'type' => 'text',
            ],
            'status' => [
                'type' => 'select',
                'options' => ['' => '--Any--'] + NewsItem::$statuses,
            ],
            'news_category_id' => [
                'title' => 'Belongs to',
                'type' => 'select',
                'options' => ['' => '--Any--'] + NewsCategory::lists('title', 'id')->toArray(),
                'query' => function ($query, $value = null) {
                    return $query->whereIn(
                        'news_items.id',
                        NewsItemCategory::where('news_category_items.news_category_id', (int) $value)->lists('news_item_id')->toArray()
                    );
                },
            ],
        ];
    }
}
