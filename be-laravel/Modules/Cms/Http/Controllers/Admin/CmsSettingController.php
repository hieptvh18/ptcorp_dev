<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CmsSettingRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms settings
 *
 * @subgroup Cms setting
 * @subgroupDescription CmsSettingController
 */
class CmsSettingController extends ApiController
{
    protected $settingService;

    public function __construct(\Modules\Cms\Services\Admin\CmsSettingService $cmsSettingService)
    {
        $this->settingService = $cmsSettingService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function getSetting($websiteId,$group)
    {
        $data = $this->settingService->getSetting($websiteId, $group);
        return $this->json(['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function saveSetting(CmsSettingRequest $request)
    {
        $item = $this->settingService->saveSetting($request);
        $data = [
            'message' => __('cms::message.setting.save_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
