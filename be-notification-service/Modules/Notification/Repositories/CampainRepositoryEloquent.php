<?php

namespace Modules\Notification\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Notification\Repositories\CampainRepository;
use Modules\Notification\Models\Campain;
use Modules\Notification\Validators\CampainValidator;

/**
 * Class CampainRepositoryEloquent.
 *
 * @package namespace Modules\Notification\Repositories;
 */
class CampainRepositoryEloquent extends BaseRepository implements CampainRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Campain::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
