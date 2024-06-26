<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseRepository;
use Modules\Cms\Models\Course;
use Modules\Cms\Validators\CourseValidator;
use Modules\Cms\Repositories\Criteria\FilterCmsCoursePublish;
/**
 * Class CourseRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseRepositoryEloquent extends BaseRepository implements CourseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Course::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'alias' => 'like',
                'code' => 'like',
                'short_description' => 'like',
                'regular_price' => 'like',
                'sale_price' => 'like',
                'address' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsCoursePublish::class));
    }

}
