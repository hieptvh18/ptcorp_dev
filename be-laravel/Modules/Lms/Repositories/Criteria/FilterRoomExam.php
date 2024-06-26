<?php

namespace Modules\Lms\Repositories\Criteria;

use Modules\Lms\Models\LmsRole;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterRoomExam implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('ids')) {
            $ids = request()->query('ids');
            $model = $model->whereIn('id',$ids);
        }

        if (request()->has('name')) {
            $name = request()->query('name');
            $model = $model->where('name','like','%'.$name.'%');
        }

        if (request()->has('author_ids')) {
            $ids = request()->query('author_ids');
            $model = $model->whereIn('updated_by',$ids);
        }

        if (request()->has('class_room_ids')) {
            $classroom_ids = request()->query('class_room_ids');
            $model = $model->whereHas('classrooms', function(Builder $query) use($classroom_ids){
                $query->whereIn('id', $classroom_ids);
            });
        }

        if (request()->has('is_active')) {
            $is_active = request()->query('is_active');
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

        return $model;
    }
}
