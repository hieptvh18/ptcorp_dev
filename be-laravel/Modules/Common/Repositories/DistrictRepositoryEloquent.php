<?php

namespace Modules\Common\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Common\Repositories\DistrictRepository;
use Modules\Common\Models\District;
use Modules\Common\Repositories\Criteria\FilterCountry;
use Modules\Common\Repositories\Criteria\FilterProvince;
use Modules\Common\Validators\DistrictValidator;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class DistrictRepositoryEloquent.
 *
 * @package namespace Modules\Common\Repositories;
 */
class DistrictRepositoryEloquent extends BaseRepository implements DistrictRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return District::class;
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
        $this->pushCriteria(app(FilterProvince::class));
    }

}
