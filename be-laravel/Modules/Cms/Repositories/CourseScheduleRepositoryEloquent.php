<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseScheduleRepository;
use Modules\Cms\Models\CourseSchedule;
use Modules\Cms\Validators\CourseScheduleValidator;

/**
 * Class CourseScheduleRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseScheduleRepositoryEloquent extends BaseRepository implements CourseScheduleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseSchedule::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
