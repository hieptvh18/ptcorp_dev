<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsSettingRepository;
use Modules\Cms\Models\CmsSetting;
use Modules\Cms\Validators\CmsSettingValidator;

/**
 * Class CmsSettingRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsSettingRepositoryEloquent extends BaseRepository implements CmsSettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsSetting::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
