<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsStudentContact implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('name')) {
            $name = strtolower(request()->query('name'));
            $model = $model->where('name','like','%'.$name.'%');
        }

        if (request()->has('mobile') ) {
            $field = request()->query('mobile');
            $model = $model->where('mobile','like','%'.$field."%");
        }

        return $model;
    }
}
