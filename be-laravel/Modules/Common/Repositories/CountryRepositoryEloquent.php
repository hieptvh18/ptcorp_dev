<?php

namespace Modules\Common\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Common\Repositories\CountryRepository;
use Modules\Common\Models\Country;
use Modules\Common\Validators\CountryValidator;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class CountryRepositoryEloquent.
 *
 * @package namespace Modules\Common\Repositories;
 */
class CountryRepositoryEloquent extends BaseRepository implements CountryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Country::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code'  => 'like',
                'postal_code' => 'like',
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
