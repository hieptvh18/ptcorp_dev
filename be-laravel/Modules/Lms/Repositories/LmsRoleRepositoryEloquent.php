<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\LmsRoleRepository;
use Modules\Lms\Models\LmsRole;
use Modules\Lms\Validators\LmsRoleValidator;

/**
 * Class LmsRoleRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class LmsRoleRepositoryEloquent extends BaseRepository implements LmsRoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return LmsRole::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'label' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsActive::class));
    }

}
