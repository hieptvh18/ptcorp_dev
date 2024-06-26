<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Modules\Lms\Repositories\Criteria\FilterRoomExam;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\ExamRoomRepository;
use Modules\Lms\Models\ExamRoom;
use Modules\Lms\Validators\ExamRoomValidator;

/**
 * Class ExamRoomRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class ExamRoomRepositoryEloquent extends BaseRepository implements ExamRoomRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExamRoom::class;
    }

    public function getFieldsSearchable()
    {
        return [
          'name'=>'like',
          'alias'=>'like',
          'description'=>'like'
        ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsActive::class));
        $this->pushCriteria(app(FilterRoomExam::class));
    }

}
