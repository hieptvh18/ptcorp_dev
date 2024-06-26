<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsReview implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('approved')) {
            $is_active = request()->query('approved') == 'true' ? true : false;
            $model = $model->where('approved',$is_active);
        }

        return $model;
    }
}
