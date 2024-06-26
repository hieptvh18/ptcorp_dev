<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsBlog implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('tag_ids')) {
            $tag_ids = request()->query('tag_ids');
            $model = $model->whereHas('tags', function(Builder $query) use($tag_ids){
                $query->whereIn('tag_id', $tag_ids);
            });
        }

        if (request()->has('category_ids')) {
            $category_ids = request()->query('category_ids');
            $model = $model->whereHas('categories', function(Builder $query) use($category_ids){
                $query->whereIn('category_id', $category_ids);
            });
        }

        return $model;
    }
}
