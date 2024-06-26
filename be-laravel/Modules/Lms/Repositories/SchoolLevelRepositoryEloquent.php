<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\SchoolLevelRepository;
use Modules\Lms\Models\SchoolLevel;
use Modules\Lms\Validators\SchoolLevelValidator;

/**
 * Class SchoolLevelRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class SchoolLevelRepositoryEloquent extends BaseRepository implements SchoolLevelRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SchoolLevel::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code' => 'like',
                'alias' => 'like',
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
