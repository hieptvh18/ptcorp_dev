<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\SubjectRepository;
use Modules\Lms\Models\Subject;
use Modules\Lms\Validators\SubjectValidator;

/**
 * Class SubjectRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class SubjectRepositoryEloquent extends BaseRepository implements SubjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subject::class;
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
