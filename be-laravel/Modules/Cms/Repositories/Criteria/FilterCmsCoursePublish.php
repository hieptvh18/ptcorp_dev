<?php

namespace Modules\Cms\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterCmsCoursePublish implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('status')) {
            $status = request()->query('status');
            $model = $model->where('status',$status);
        }

        if (request()->has('type') ) {
            $type = request()->query('type');
            $model = $model->where('type',$type);
        }

        if (request()->has('category_id') ) {
            $category_id = request()->query('category_id');
            $model = $model->whereHas('categories', function(Builder $query) use($category_id){
                $query->where('lms_cms_categories.id', $category_id);
            });
        }

        if (request()->has('category_ids')) {
            $category_ids = request()->query('category_ids');
            $model = $model->whereHas('categories', function(Builder $query) use($category_ids){
                $query->whereIn('lms_cms_categories.id', $category_ids);
            });
        }

        if (request()->has('level_ids')) {
            $level_ids = request()->query('level_ids');
            $model = $model->whereHas('levels', function(Builder $query) use($level_ids){
                $query->whereIn('lms_cms_course_level.id', $level_ids);
            });
        }

        if (request()->has('instructor_ids')) {
            $ids = request()->query('instructor_ids');
            $model = $model->whereHas('instructors', function(Builder $query) use($ids){
                $query->whereIn('lms_course_instructors.id', $ids);
            });
        }

        if (request()->has('language_ids')) {
            $ids = request()->query('language_ids');
            $model = $model->whereHas('languages', function(Builder $query) use($ids){
                $query->whereIn('lms_course_languages.id', $ids);
            });
        }

        if (request()->has('price_type')) {
            $priceType = request()->query('price_type');
            switch ($priceType){
                case 'paid':
                    $model = $model->where([['regular_price','>',0],['sale_price','<>',null]])
                                ->orWhere([['regular_price','>',0],['sale_price','=',null]])
                                ->orWhere([['regular_price','=',0],['sale_price','<>',null]]);
                    break;
                case 'free':
                    $model = $model->where([['regular_price','=',0],['sale_price','=',null]])
                        ->orWhere([['regular_price','>',0],['sale_price','=',0]]);
                    break;
                default: // all
                    break;
            }
        }

        return $model;
    }
}
