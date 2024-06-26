<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseSectionRepository;
use Modules\Cms\Models\CourseSection;
use Modules\Cms\Validators\CourseSectionValidator;

/**
 * Class CourseSectionRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseSectionRepositoryEloquent extends BaseRepository implements CourseSectionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseSection::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
