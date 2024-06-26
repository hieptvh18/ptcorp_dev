<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsBannerRepository;
use Modules\Cms\Models\CmsBanner;
use Modules\Cms\Validators\CmsBannerValidator;
use Modules\Cms\Repositories\Criteria\FilterCmsBanner;

/**
 * Class CmsBannerRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsBannerRepositoryEloquent extends BaseRepository implements CmsBannerRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsBanner::class;
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
        $this->pushCriteria(app(FilterCmsBanner::class));
    }

}
