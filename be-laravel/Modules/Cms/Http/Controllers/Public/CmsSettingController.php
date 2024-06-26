<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Services\Public\CmsSettingService;

/**
 * @group Module Cms
 *
 * APIs public for cms setting public
 *
 * @subgroup Cms setting public
 * @subgroupDescription CmsSettingController
 */
class CmsSettingController extends ApiController
{
    protected $settingService;

    public function __construct(CmsSettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Api public lấy thông tin cấu hình
     *
     * @param $group
     * @return Response
     */
    public function getSettingGroup($group)
    {
        $data = $this->settingService->getSettingGroup($group);
        return $this->json($data);
    }
}

