<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Admin\CmsBannerCreateRequest;
use Modules\Cms\Http\Requests\Admin\CmsBannerUpdateRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms banner
 *
 * @subgroup Cms Banner
 * @subgroupDescription AdminCmsBannerController
 */
class AdminCmsBannerController extends ApiController
{
    /**
     * @var \Modules\Cms\Services\Admin\AdminCmsBannerService
     */
    protected $cmsBannerService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminCmsBannerService $adminCmsBannerService,
    )
    {
        $this->cmsBannerService = $adminCmsBannerService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsBannerService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CmsBannerCreateRequest $request)
    {
        $item = $this->cmsBannerService->create($request);
        $data = [
            'message' => __('cms::message.banner.create_success'),
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
        $item = $this->cmsBannerService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsBannerUpdateRequest $request, $id)
    {
        $item = $this->cmsBannerService->update($request,$id);
        $data = [
            'message' => __('cms::message.banner.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsBannerService->delete($id);
        $data = [
            'message' => __("cms::message.banner.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
