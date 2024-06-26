<?php

namespace Modules\Cms\Repositories;

use Modules\Cms\Repositories\Criteria\FilterCmsFaqCategory;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsFaqCategoryRepository;
use Modules\Cms\Models\FaqCategory;
use Modules\Cms\Validators\FaqCategoryValidator;

/**
 * Class FaqCategoryRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsFaqCategoryRepositoryEloquent extends BaseRepository implements CmsFaqCategoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FaqCategory::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'description' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsFaqCategory::class));
    }

}
