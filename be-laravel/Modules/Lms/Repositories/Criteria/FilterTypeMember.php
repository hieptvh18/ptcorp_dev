<?php

namespace Modules\Lms\Repositories\Criteria;

use Modules\Lms\Models\LmsRole;
use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterTypeMember implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('role_name')) {
            $role_name = strtolower(request()->query('role_name'));
            $role = LmsRole::where('name', $role_name)->first();
            $model = $model->whereHas('roles', function($query) use($role){
                $query->where('name', $role->name);
            });
        }

        return $model;
    }
}
