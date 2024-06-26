<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsBlogTagRepository;
use Modules\Cms\Models\CmsBlogTag;
use Modules\Cms\Validators\CmsBlogTagValidator;

/**
 * Class CmsBlogTagRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsBlogTagRepositoryEloquent extends BaseRepository implements CmsBlogTagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsBlogTag::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
