<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsCategoryRepository;
use Modules\Cms\Models\CmsCategory;
use Modules\Cms\Validators\CmsCategoryValidator;
use Modules\Cms\Repositories\Criteria\FilterCmsCategory;
/**
 * Class CmsCategoryRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsCategoryRepositoryEloquent extends BaseRepository implements CmsCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsCategory::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'alias'=>'like',
                'code'=>'like',
                'description'=>"like"
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsCategory::class));
    }

}
