<?php

namespace Modules\Notification\Services\Admin;

use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Carbon;
use Modules\Notification\Repositories\CampainRepository;

class CampainAdminService extends BaseService
{

    public function __construct(CampainRepository $campainRepository)
    {
        $this->baseRepository = $campainRepository;
    }

}
