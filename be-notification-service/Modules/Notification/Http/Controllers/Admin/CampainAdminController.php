<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Notification\Http\Requests\CampainCreateRequest;
use Modules\Notification\Http\Requests\CampainUpdateRequest;
use Modules\Notification\Services\Admin\CampainAdminService;
use Modules\Notification\Services\Admin\EmailLogAdminService;

/**
 * @group Module Notification
 *
 * APIs for managing endpoint Notification
 *
 * @subgroup Notification campain Management
 * @subgroupDescription CampaintAdminController
 */
class CampainAdminController extends ApiController
{

    protected $campainAdminService;
    public function __construct(CampainAdminService $campainAdminService)
    {
        $this->campainAdminService = $campainAdminService;
    }
    /**
     * Danh sách lịch sử gửi mail
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->campainAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Tạo biểu mẫu thông báo email
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CampainCreateRequest $request)
    {
        $item = $this->campainAdminService->create($request);
        $data = [
            'message' => __('notification::message.campain.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết biểu mẫu thông báo email
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->campainAdminService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Sửa thông tin biểu mẫu thông báo email
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CampainUpdateRequest $request, $id)
    {
        $item = $this->campainAdminService->update($request, $id);
        $data = [
            'message' => __('notification::message.campain.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa biểu mẫu thông báo email
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->campainAdminService->delete($id);
        $data = [
            'message' => __('notification::message.campain.delete_success'),
        ];
        return $this->json($data);
    }
}
