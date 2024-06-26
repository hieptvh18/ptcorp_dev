<?php

namespace Modules\Common\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Common\Repositories\WardRepository;
use Modules\Common\Models\Ward;
use Modules\Common\Validators\WardValidator;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class WardRepositoryEloquent.
 *
 * @package namespace Modules\Common\Repositories;
 */
class WardRepositoryEloquent extends BaseRepository implements WardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ward::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code'  => 'like',
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
