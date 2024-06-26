<?php

namespace Modules\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Cms\Http\Requests\SaveSettingRequest;
use Modules\Cms\Services\Admin\AdminCmsSettingService;

/**
 * @group Module Cms
 *
 * APIs for managing cms setting
 *
 * @subgroup Cms setting
 * @subgroupDescription AdminCmsSettingController
 */
class AdminCmsSettingController extends ApiController
{
    /**
     * @var \Modules\Cms\Services\Admin\AdminCmsSettingService
     */
    protected $adminCmsSettingService;

    public function __construct(AdminCmsSettingService $adminCmsSettingService,)
    {
        $this->adminCmsSettingService = $adminCmsSettingService;
    }

    /**
     * Lưu cài đặt
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function saveSetting(SaveSettingRequest $request)
    {
        $item = $this->adminCmsSettingService->saveSetting($request);
        $data = [
            'message' => __('cms::message.setting.save_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Lấy cấu hình
     *
     * Store a newly created resource in storage.
     * @param string $group
     * @param string $name
     * @return Response
     */
    public function getSetting($group, $name)
    {
        $data = $this->adminCmsSettingService->getSetting($group, $name);
        return $this->json(['data' => $data]);
    }
}
