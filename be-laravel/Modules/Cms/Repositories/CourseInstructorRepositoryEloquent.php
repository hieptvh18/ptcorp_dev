<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseInstructorRepository;
use Modules\Cms\Models\CourseInstructor;
use Modules\Cms\Validators\CourseInstructorValidator;

/**
 * Class CourseInstructorRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseInstructorRepositoryEloquent extends BaseRepository implements CourseInstructorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseInstructor::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'description' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
