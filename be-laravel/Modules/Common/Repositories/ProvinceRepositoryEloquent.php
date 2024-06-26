<?php

namespace Modules\Common\Repositories;

use Modules\Common\Models\Province;
use Modules\Common\Repositories\Criteria\FilterCountry;
use Prettus\Repository\Eloquent\BaseRepository;
use Modules\Common\Validators\ProvinceValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Common\Repositories\ProvinceRepository;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class ProvinceRepositoryEloquent.
 *
 * @package namespace Modules\Common\Repositories;
 */
class ProvinceRepositoryEloquent extends BaseRepository implements ProvinceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Province::class;
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
        $this->pushCriteria(app(FilterCountry::class));
    }

}
