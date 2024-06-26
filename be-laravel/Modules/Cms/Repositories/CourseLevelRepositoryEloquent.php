<?php

namespace Modules\Cms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseLevelRepository;
use Modules\Cms\Models\CourseLevel;
use Modules\Cms\Validators\CourseLevelValidator;

/**
 * Class CourseLevelRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseLevelRepositoryEloquent extends BaseRepository implements CourseLevelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseLevel::class;
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
        $this->pushCriteria(app(FilterIsActive::class));
    }

}
