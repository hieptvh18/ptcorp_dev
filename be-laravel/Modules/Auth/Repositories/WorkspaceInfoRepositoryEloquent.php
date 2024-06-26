<?php

namespace Modules\Auth\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Auth\Repositories\WorkspaceInfoRepository;
use Modules\Auth\Models\WorkspaceInfo;
use Modules\Auth\Validators\WorkspaceInfoValidator;

/**
 * Class WorkspaceInfoRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class WorkspaceInfoRepositoryEloquent extends BaseRepository implements WorkspaceInfoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkspaceInfo::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'short_name' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
