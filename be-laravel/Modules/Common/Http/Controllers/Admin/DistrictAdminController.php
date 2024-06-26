<?php

namespace Modules\Common\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Common\Http\Requests\DistrictCreateRequest;
use Modules\Common\Http\Requests\DistrictUpdateRequest;
use Modules\Common\Services\Admin\DistrictAdminService;

/**
 * @group Module Common
 * APIs for Common
 *
 * @subgroup Admin Quản lý quận/huyện
 * @subgroupDescription Class DistrictAdminController.
 * @package namespace Modules\Common\Http\Controllers\Admin;
 */
class DistrictAdminController extends ApiController
{
    protected $districtAdminService;
    public function __construct(DistrictAdminService $districtAdminService)
    {
        $this->districtAdminService = $districtAdminService;
    }

    /**
     * Danh sách quận/huyện
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->districtAdminService->getList($request);
        return $this->json($data);
    }

    /**
     * Thêm quận/huyện
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(DistrictCreateRequest $request)
    {
        $item = $this->districtAdminService->create($request);
        $data = [
            'message' => __('common::message.district.create_success'),
            'data' => $item,
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->districtAdminService->find($id)->load(['country', 'province']);
        return $this->json(['data' => $data]);
    }

    /**
     * Chỉnh sửa quận/huyện
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(DistrictUpdateRequest $request, $id)
    {
        $item = $this->districtAdminService->update($request, $id);
        $data = [
            'message' => __('common::message.district.updated_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa quận/huyện
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->districtAdminService->delete($id);
        $data = [
            'message' => __('common::message.district.deleted_success'),
            'deleted' => $item
        ];
        return $this->json($data);
    }
}
