<?php

namespace Modules\Auth\Services;

use App\Services\BaseService;
use Modules\Auth\Repositories\PermissionRepository;

class PermissionService extends BaseService{

    public function __construct(PermissionRepository $repository) {
        $this->baseRepository = $repository;
    }
}
