<?php

namespace Modules\Notification\Services\Admin;

use App\Services\BaseService;
use Modules\Notification\Repositories\DeviceTokenRepository;

class DeviceTokenAdminService extends BaseService
{

    public function __construct(DeviceTokenRepository $deviceTokenRepository)
    {
        $this->baseRepository = $deviceTokenRepository;
    }

}
