<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsFeedback implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('name')) {
            $name = strtolower(request()->query('name'));
            $model = $model->where('name','like','%'.$name.'%');
        }

        if (request()->has('student_name')) {
            $name = strtolower(request()->query('student_name'));
            $model = $model->where('student_name','like','%'.$name.'%');
        }

        if (request()->has('sort_order')) {
            $name = strtolower(request()->query('sort_order'));
            $model = $model->where('sort_order',$name);
        }

        if (request()->has('is_active')) {
            $is_active = request()->query('is_active') == 'true' ? true : false;
            $model = $model->where('is_active',$is_active);
        }

        return $model;
    }
}
