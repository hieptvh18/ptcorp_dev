<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Notification\Http\Requests\EmailTemplateCreateRequest;
use Modules\Notification\Http\Requests\EmailTemplateUpdateRequest;
use Modules\Notification\Services\Admin\EmailTemplateAdminService;

/**
 * @group Module Notification
 *
 * APIs for managing endpoint Notification
 *
 * @subgroup Notification email template Management
 * @subgroupDescription EmailTemplateAdminController
 */
class EmailTemplateAdminController extends ApiController
{

    protected $emailTemplateAdminService;
    public function __construct(EmailTemplateAdminService $emailTemplateAdminService)
    {
        $this->emailTemplateAdminService = $emailTemplateAdminService;
    }
    /**
     * Danh sách biểu mẫu thông báo email
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->emailTemplateAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Tạo biểu mẫu thông báo email
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(EmailTemplateCreateRequest $request)
    {
        $item = $this->emailTemplateAdminService->create($request);
        $data = [
            'message' => __('notification::message.email_template.create_success'),
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
        $data = $this->emailTemplateAdminService->find($id);
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
    public function update(EmailTemplateUpdateRequest $request, $id)
    {
        $item = $this->emailTemplateAdminService->update($request, $id);
        $data = [
            'message' => __('notification::message.email_template.update_success'),
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
        $item = $this->emailTemplateAdminService->delete($id);
        $data = [
            'message' => __('notification::message.email_template.delete_success'),
        ];
        return $this->json($data);
    }
}
