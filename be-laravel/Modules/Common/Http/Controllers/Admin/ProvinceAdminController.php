<?php

namespace Modules\Common\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Common\Http\Requests\ProvinceCreateRequest;
use Modules\Common\Http\Requests\ProvinceUpdateRequest;
use Modules\Common\Services\Admin\ProvinceAdminService;

/**
 * @group Module Common
 * APIs for Common
 *
 * @subgroup Admin Quản lý tỉnh thành
 * @subgroupDescription Class ProvinceAdminController.
 * @package namespace Modules\Common\Http\Controllers\Admin;
 */
class ProvinceAdminController extends ApiController
{
    protected $provinceAdminService;
    public function __construct(ProvinceAdminService $provinceAdminService)
    {
        $this->provinceAdminService = $provinceAdminService;
    }

    /**
     * Danh sách tỉnh thành
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->provinceAdminService->getList($request);
        return $this->json($data);
    }

    /**
     * Thêm tỉnh thành
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(ProvinceCreateRequest $request)
    {
        $item = $this->provinceAdminService->create($request);
        $data = [
            'message' => __('common::message.province.create_success'),
            'data' => $item,
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết tỉnh thành
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->provinceAdminService->find($id)->load('country');
        return $this->json(['data' => $data]);
    }

    /**
     * Chỉnh sửa tỉnh thành
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ProvinceUpdateRequest $request, $id)
    {
        $item = $this->provinceAdminService->update($request, $id);
        $data = [
            'message' => __('common::message.province.updated_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa tỉnh thành
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->provinceAdminService->delete($id);
        $data = [
            'message' => __('common::message.province.deleted_success'),
            'deleted' => $item
        ];
        return $this->json($data);
    }
}
