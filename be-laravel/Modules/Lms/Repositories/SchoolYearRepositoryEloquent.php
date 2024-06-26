<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\SchoolYearRepository;
use Modules\Lms\Models\SchoolYear;
use Modules\Lms\Validators\SchoolYearValidator;

/**
 * Class SchoolYearRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class SchoolYearRepositoryEloquent extends BaseRepository implements SchoolYearRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SchoolYear::class;
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
