<?php

namespace Modules\Lms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\NotificationRepository;
use Modules\Lms\Models\Notification;
use Modules\Lms\Validators\NotificationValidator;

/**
 * Class NotificationRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class NotificationRepositoryEloquent extends BaseRepository implements NotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'title' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
