<?php

namespace Modules\Common\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Common\Http\Requests\WardCreateRequest;
use Modules\Common\Http\Requests\WardUpdateRequest;
use Modules\Common\Services\Admin\WardAdminService;

/**
 * @group Module Common
 * APIs for Common
 *
 * @subgroup Admin Quản lý phường/xã
 * @subgroupDescription Class WardAdminController.
 * @package namespace Modules\Common\Http\Controllers\Admin;
 */
class WardAdminController extends ApiController
{
    protected $wardAdminService;
    public function __construct(WardAdminService $wardAdminService)
    {
        $this->wardAdminService = $wardAdminService;
    }

    /**
     * Danh sách phường/xã
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->wardAdminService->getList($request);
        return $this->json($data);
    }

    /**
     * Thêm phường/xã
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(WardCreateRequest $request)
    {
        $item = $this->wardAdminService->create($request);
        $data = [
            'message' => __('common::message.ward.create_success'),
            'data' => $item,
        ];
        return $this->json($data);
    }

    /**
     * chi tiết
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->wardAdminService->find($id)->load(['country', 'province', 'district']);
        return $this->json(['data' => $data]);
    }

    /**
     * Chỉnh sửa
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(WardUpdateRequest $request, $id)
    {
        $item = $this->wardAdminService->update($request, $id);
        $data = [
            'message' => __('common::message.ward.updated_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa phường/xã
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->wardAdminService->delete($id);
        $data = [
            'message' => __('common::message.ward.deleted_success'),
            'deleted' => $item
        ];
        return $this->json($data);
    }
}
