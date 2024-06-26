<?php

namespace Modules\Common\Http\Controllers\Admin\Setting;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Common\Services\Admin\Setting\FlagSettingAdminService;
use Modules\Common\Settings\FlagSettings;

/**
 * @group Module Common
 * APIs for Common
 *
 *
 * @subgroup cấu hình cache
 * @subgroupDescription Class FlagSettingAdminController.
 * @package namespace Modules\Common\Http\Controllers\Admin\Settings;
 */
class FlagSettingAdminController extends ApiController
{
    protected $flagSettingAdminService;

    public function __construct(FlagSettingAdminService $flagSettingAdminService)
    {
        $this->flagSettingAdminService = $flagSettingAdminService;
    }

     /**
     * Admin lấy cấu hình cờ
     *
     * Display a listing of the resource.
     * @return Renderable
     */
    public function getFlagSetting(Request $request){
        $data = $this->flagSettingAdminService->getFlagSetting($request);
        return $this->json($data);
    }

}
