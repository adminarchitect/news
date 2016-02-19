<?php

namespace Terranet\News\Modules;

use App\NewsCategory;
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
 * Administrator Resource NewsCategories
 *
 * @package Terranet\Administrator
 */
class NewsCategories extends Resource implements Navigable, Filtrable, Editable, Validable, Sortable, Exportable
{
    use HasFilters, HasForm, HasSortable, ValidatesForm, AllowFormats;

    /**
     * The module Eloquent model
     *
     * @var string
     */
    protected $model = NewsCategory::class;

    public function title()
    {
        return "Categories";
    }

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

    public function form()
    {
        return array_except($this->scaffoldForm(), ['slug']);
    }

    public function filters()
    {
        return array_except($this->scaffoldFilters(), ['slug']);
    }

    public function columns()
    {
        return array_merge(
            $this->scaffoldColumns(),
            [
                'news' => [
                    'output' => function ($row) {
                        return $this->renderNewsColumn($row);
                    },
                ],
            ]
        );
    }

    /**
     * @param $row
     * @return mixed
     */
    protected function renderNewsColumn($row)
    {
        $out = [];

        if ($news = $row->news()->count()) {
            $out[] = link_to_route(
                'scaffold.index',
                'View all news (' . $news . ')',
                ['module' => 'news_items', 'news_category_id' => $row->id]
            );
        }

        $out[] = link_to_route(
            'scaffold.create',
            '+ Create news',
            ['module' => 'news_items', 'news_category_id' => $row->id]
        );

        return join("<br />", $out);
    }
}