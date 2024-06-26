<?php

namespace Modules\Auth\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Auth\Repositories\WorkspaceWebsiteRepository;
use Modules\Auth\Models\WorkspaceWebsite;
use Modules\Auth\Validators\WorkspaceWebsiteValidator;
use Modules\Core\Repositories\Criteria\FilterIsActive;

/**
 * Class WorkspaceWebsiteRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class WorkspaceWebsiteRepositoryEloquent extends BaseRepository implements WorkspaceWebsiteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WorkspaceWebsite::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'workspace_alias' => 'like',
                'title' => 'like',
                'slogan' => 'like',
                'email' => 'like',
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
