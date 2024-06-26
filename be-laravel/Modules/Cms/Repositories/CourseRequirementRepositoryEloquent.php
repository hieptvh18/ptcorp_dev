<?php

namespace Modules\Cms\Repositories;

use Modules\Cms\Repositories\Criteria\FilterCmsCourseRequirement;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseRequirementRepository;
use Modules\Cms\Models\CourseRequirement;
use Modules\Cms\Validators\CourseRequirementValidator;

/**
 * Class CourseRequirementRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseRequirementRepositoryEloquent extends BaseRepository implements CourseRequirementRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseRequirement::class;
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
        $this->pushCriteria(app(FilterCmsCourseRequirement::class));
    }

}
