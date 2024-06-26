<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseLessionRepository;
use Modules\Cms\Models\CourseLession;
use Modules\Cms\Validators\CourseLessionValidator;

/**
 * Class CourseLessionRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseLessionRepositoryEloquent extends BaseRepository implements CourseLessionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseLession::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
