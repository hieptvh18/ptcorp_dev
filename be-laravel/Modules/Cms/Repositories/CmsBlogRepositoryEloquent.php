<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsBlogRepository;
use Modules\Cms\Models\CmsBlog;
use Modules\Cms\Repositories\Criteria\FilterCmsBlog;
use Modules\Cms\Validators\CmsBlogValidator;
use Modules\Core\Repositories\Criteria\FilterBizapp;
use Modules\Core\Repositories\Criteria\FilterStatus;

/**
 * Class CmsBlogRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsBlogRepositoryEloquent extends BaseRepository implements CmsBlogRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsBlog::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code' => 'like',
                'alias' => 'like',
                'short_description' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsBlog::class));
        $this->pushCriteria(app(FilterStatus::class));
        $this->pushCriteria(app(FilterBizapp::class));

    }

}
