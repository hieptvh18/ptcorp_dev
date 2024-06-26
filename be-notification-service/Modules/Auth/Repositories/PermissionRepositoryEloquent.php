<?php

namespace Modules\Auth\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Auth\Repositories\PermissionRepository;
use Spatie\Permission\Models\Permission;
use Modules\Auth\Validators\PermissionValidator;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class PermissionRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class PermissionRepositoryEloquent extends BaseRepository implements PermissionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Permission::class;
    }

    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsActive::class));
    }
}
