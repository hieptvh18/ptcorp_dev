<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsFaq implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('faq_category_id')) {
            $cate = request()->query('faq_category_id');
            $model = $model->where('faq_category_id',$cate);
        }

        if (request()->has('is_active')) {
            $is_active = request()->query('is_active') == 'true' ? true : false;
            $model = $model->where('is_active',$is_active);
        }

        return $model;
    }
}
