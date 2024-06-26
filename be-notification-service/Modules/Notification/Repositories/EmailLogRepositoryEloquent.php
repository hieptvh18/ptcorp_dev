<?php

namespace Modules\Notification\Repositories;

use Modules\Core\Repositories\Criteria\FilterStatus;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Notification\Repositories\EmailLogRepository;
use Modules\Notification\Models\EmailLog;
use Modules\Notification\Validators\EmailLogValidator;

/**
 * Class EmailLogRepositoryEloquent.
 *
 * @package namespace Modules\Notification\Repositories;
 */
class EmailLogRepositoryEloquent extends BaseRepository implements EmailLogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailLog::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'subject' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterStatus::class));
    }

}
