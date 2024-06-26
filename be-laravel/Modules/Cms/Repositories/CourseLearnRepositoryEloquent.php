<?php

namespace Modules\Cms\Repositories;

use Modules\Cms\Repositories\Criteria\FilterCmsCourseLearn;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseLearnRepository;
use Modules\Cms\Models\CourseLearn;
use Modules\Cms\Validators\CourseLearnValidator;

/**
 * Class CourseLearnRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseLearnRepositoryEloquent extends BaseRepository implements CourseLearnRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseLearn::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsCourseLearn::class));
    }

}
