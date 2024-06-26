<?php

namespace Modules\Auth\Services;

use App\Services\BaseService;
use Modules\Auth\Repositories\RoleRepository;

class RoleService extends BaseService{

    public function __construct(RoleRepository $roleRepository) {
        $this->baseRepository = $roleRepository;
    }
}
