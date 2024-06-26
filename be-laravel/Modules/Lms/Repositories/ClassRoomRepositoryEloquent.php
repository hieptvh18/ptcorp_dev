<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Modules\Core\Repositories\Criteria\FilterStatus;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\ClassRoomRepository;
use Modules\Lms\Models\ClassRoom;
use Modules\Lms\Validators\ClassRoomValidator;

/**
 * Class ClassRoomRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class ClassRoomRepositoryEloquent extends BaseRepository implements ClassRoomRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassRoom::class;
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
        $this->pushCriteria(app(FilterIsActive::class));
        $this->pushCriteria(app(FilterStatus::class));
    }

}
