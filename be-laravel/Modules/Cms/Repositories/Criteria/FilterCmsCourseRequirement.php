<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsCourseRequirement implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('is_active')) {
            $is_active = request()->query('is_active') == 'true' ? true : false;
            $model = $model->where('is_active',$is_active);
        }
        return $model;
    }
}
