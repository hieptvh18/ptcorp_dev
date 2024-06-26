<?php

namespace Modules\Auth\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Auth\Repositories\WorkspaceWebsiteDomainRepository;

class AdminWorkspaceWebsiteDomainService extends BaseService
{
    public function __construct(WorkspaceWebsiteDomainRepository $repository)
    {
        $this->baseRepository = $repository;
    }

}
