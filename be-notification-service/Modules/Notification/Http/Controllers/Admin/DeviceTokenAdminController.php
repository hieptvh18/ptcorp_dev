<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Notification\Services\Admin\DeviceTokenAdminService;

/**
 * @group Module Notification
 *
 * APIs for managing endpoint Notification
 *
 * @subgroup Notification device token Management
 * @subgroupDescription DeviceTokenAdminController
 */
class DeviceTokenAdminController extends ApiController
{

    protected $deviceTokenAdminService;
    public function __construct(DeviceTokenAdminService $deviceTokenAdminService)
    {
        $this->deviceTokenAdminService = $deviceTokenAdminService;
    }
    /**
     * Danh sách device token
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->deviceTokenAdminService->getList($request);
        return $this->json($data, 200);
    }

}
