<?php

namespace Modules\Notification\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Notification\Services\Admin\EmailLogAdminService;

/**
 * @group Module Notification
 *
 * APIs for managing endpoint Notification
 *
 * @subgroup Notification email log Management
 * @subgroupDescription EmailLogAdminController
 */
class EmailLogAdminController extends ApiController
{

    protected $emailLogAdminService;
    public function __construct(EmailLogAdminService $emailLogAdminService)
    {
        $this->emailLogAdminService = $emailLogAdminService;
    }
    /**
     * Danh sách lịch sử gửi mail
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->emailLogAdminService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Chi tiết lịch sử gửi mail
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->emailLogAdminService->find($id)->load(['template:id,name']);
        return $this->json(['data' => $data]);
    }
}
