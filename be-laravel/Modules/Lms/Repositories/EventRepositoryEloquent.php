<?php

namespace Modules\Lms\Repositories;

use Modules\Lms\Models\Event;
use Modules\Lms\Validators\EventValidator;
use Modules\Lms\Repositories\EventRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\Criteria\FilterType;
use Modules\Core\Repositories\Criteria\FilterStatus;

/**
 * Class EventRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class EventRepositoryEloquent extends BaseRepository implements EventRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Event::class;
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
        $this->pushCriteria(app(FilterType::class));
        $this->pushCriteria(app(FilterStatus::class));
    }

}
