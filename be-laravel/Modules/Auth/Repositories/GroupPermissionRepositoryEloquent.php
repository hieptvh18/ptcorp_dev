<?php

namespace Modules\Auth\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Auth\Repositories\GroupPermissionRepository;
use Modules\Auth\Models\GroupPermission;
use Modules\Auth\Validators\GroupPermissionValidator;

/**
 * Class GroupPermissionRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class GroupPermissionRepositoryEloquent extends BaseRepository implements GroupPermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return GroupPermission::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
