<?php

namespace Modules\Lms\Repositories\Criteria;

use Modules\Lms\Models\LmsRole;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterMember implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('role_ids')) {
            $role_ids = request()->query('role_ids');
            $model = $model->whereHas('roles', function(Builder $query) use($role_ids){
                $query->whereIn('id', $role_ids);
            });
        }

        if (request()->has('classroom_parent_ids')) {
            $classroom_parent_ids = request()->query('classroom_parent_ids');
            $model = $model->whereHas('classrooms', function(Builder $query) use($classroom_parent_ids){
                $query->whereIn('id', $classroom_parent_ids)->where('parent_id', 0);
            });
        }

        if (request()->has('classroom_child_ids')) {
            $classroom_child_ids = request()->query('classroom_child_ids');
            $model = $model->whereHas('classrooms', function(Builder $query) use($classroom_child_ids){
                $query->whereIn('id', $classroom_child_ids)->where('parent_id', '<>', 0);
            });
        }

        if(request()->has('school_year_ids')){
            $school_year_ids = request()->query('school_year_ids');
            $model = $model->whereHas('schoolYears', function(Builder $query) use($school_year_ids){
                $query->whereIn('id', $school_year_ids);
            });
        }
        if(request()->has('subject_ids')){
            $subject_ids = request()->query('subject_ids');
            $model = $model->whereHas('subjects', function(Builder $query) use($subject_ids){
                $query->whereIn('id', $subject_ids);
            });
        }

        return $model;
    }
}
