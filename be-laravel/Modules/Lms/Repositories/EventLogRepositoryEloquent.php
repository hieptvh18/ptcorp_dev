<?php

namespace Modules\Lms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\EventLogRepository;
use Modules\Lms\Models\EventLog;
use Modules\Lms\Validators\EventLogValidator;

/**
 * Class EventLogRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class EventLogRepositoryEloquent extends BaseRepository implements EventLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EventLog::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
