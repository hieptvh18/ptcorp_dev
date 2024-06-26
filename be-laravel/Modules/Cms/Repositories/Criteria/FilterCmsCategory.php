<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsCategory implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {

        if (request()->has('is_active')) {
            $is_active = request()->query('is_active') == 'true' ? true : false;
            $model = $model->where('is_active',$is_active);
        }

        if (request()->has('type')) {
            $type = request()->query('type');
            $model = $model->where('type',$type);
        }

        return $model;
    }
}
