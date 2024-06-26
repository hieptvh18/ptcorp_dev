<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\NotificationConfigRepository;
use Modules\Lms\Models\NotificationConfig;
use Modules\Lms\Validators\NotificationConfigValidator;

/**
 * Class NotificationConfigRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class NotificationConfigRepositoryEloquent extends BaseRepository implements NotificationConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NotificationConfig::class;
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
