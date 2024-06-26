<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsBanner implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('name')) {
            $name = strtolower(request()->query('name'));
            $model = $model->where('name','like','%'.$name.'%');
        }

        if (request()->has('is_active')) {
            $is_active = request()->query('is_active') == 'true' ? true : false;
            $model = $model->where('is_active',$is_active);
        }

        if (request()->has('start_date') ) {
            $start_date = request()->query('start_date');
            $model = $model->where('start_date','>=',$start_date);
        }

        if (request()->has('end_date') ) {
            $end_date = request()->query('end_date');
            $model = $model->where('end_date','<=',$end_date);
        }

        if (request()->has('position') ) {
            $position = strtolower(request()->query('position'));
            $model = $model->where('position',$position);
        }

        return $model;
    }
}
