<?php

namespace Modules\Lms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Http\Requests\Admin\MemberGetListRequest;
use Modules\Lms\Services\Admin\AdminWorkspaceService;
use Modules\Auth\Http\Requests\ChangeRoleWorkspaceRequest;

/**
 * @group Module Lms
 *
 * APIs for managing admin workspace
 *
 * @subgroup Workspace admin
 * @subgroupDescription WorkspaceController
 */
class AdminWorkspaceController extends ApiController
{
    protected $workspaceService;

    public function __construct(AdminWorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    /**
     * Workspace statistical
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function workspaceStatistical(Request $request)
    {
        $data = $this->workspaceService->workspaceStatis($request);
        return $this->json($data);
    }

    /**
     * Thay đổi vai trò
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function changeRole(ChangeRoleWorkspaceRequest $request)
    {
        $data = $this->workspaceService->changeRole($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Thống báo
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function workspaceNotification(Request $request)
    {
        $data = $this->workspaceService->workspaceNotification($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Sự kiện
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function workspaceEvent(Request $request)
    {
        $data = $this->workspaceService->workspaceEvent($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Thành viên
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function workspaceMember(MemberGetListRequest $request)
    {
        $data = $this->workspaceService->workspaceMember($request);
        return $this->json(['data' => $data]);
    }

    /**
     * classroom
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function workspaceClassroom(Request $request)
    {
        $data = $this->workspaceService->workspaceClassroom($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Chương trình đào tạo
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function workspaceTrainingProgram(Request $request)
    {
        $data = $this->workspaceService->workspaceTrainingProgram($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Xóa thành viên khỏi workspace
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function detachTeamWork($id, Request $request)
    {
        $data = $this->workspaceService->detachTeamWork($id, $request);
        return $this->json(['data' => $data]);
    }

}
