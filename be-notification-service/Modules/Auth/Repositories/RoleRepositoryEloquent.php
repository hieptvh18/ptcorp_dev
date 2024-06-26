<?php

namespace Modules\Auth\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Auth\Repositories\RoleRepository;

use Modules\Auth\Validators\RoleValidator;
use Modules\Core\Repositories\Criteria\FilterIsActive;
use Spatie\Permission\Models\Role;

/**
 * Class RoleRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class RoleRepositoryEloquent extends BaseRepository implements RoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Role::class;
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
