<?php

namespace Modules\Auth\Repositories;

use FilterIterator;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Auth\Repositories\WorkspaceWebsiteDomainRepository;
use Modules\Auth\Models\WorkspaceWebsiteDomain;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class WorkspaceWebsiteDomainRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class WorkspaceWebsiteDomainRepositoryEloquent extends BaseRepository implements WorkspaceWebsiteDomainRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkspaceWebsiteDomain::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'domain' => 'like',
                'sub_domain' => 'like',
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
