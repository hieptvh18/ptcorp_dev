<?php

namespace Modules\Auth\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\User\WorkspaceInfoService;
use Modules\Auth\Http\Requests\AddMemberWorkspaceRequest;
use Modules\Auth\Http\Requests\ChangeRoleWorkspaceRequest;
use Modules\Auth\Http\Requests\WorkspaceInfoCreateRequest;
use Modules\Auth\Http\Requests\WorkspaceInfoUpdateRequest;

/**
 * @group Module Auth
 *
 * APIs for managing workspace
 *
 * @subgroup User Workspace info
 * @subgroupDescription WorkspaceInfoController
 */
class WorkspaceInfoController extends ApiController
{
    protected $workSpaceInfoService;

    public function __construct(WorkspaceInfoService $workSpaceInfoService)
    {
        $this->workSpaceInfoService = $workSpaceInfoService;
    }

    /**
     * Danh sách workspace
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Thêm mới
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(WorkspaceInfoCreateRequest $request)
    {
        $item = $this->workSpaceInfoService->create($request);
        $data = [
            'message' => __('auth::message.workspace.create_success'),
            'data' => $item
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
        //
    }

    /**
     * Chỉnh sửa
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(WorkspaceInfoUpdateRequest $request, $id)
    {
        $item = $this->workSpaceInfoService->update($request, $id);
        $data = [
            'message' => __('auth::message.workspace.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Danh sách workspace được phép truy cập
     *
     * Display a listing of the workspace allow access.
     * @param Request $request
     * @return Response
     */
    public function getMyAccessWorkspace(Request $request)
    {
        $data = $this->workSpaceInfoService->getMyAccessWorkspace($request);
        return $this->json($data);
    }

    /**
     * Thêm thành viên vào workspace
     *
     * Store a newly created resource in storage.
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function addMembers($id, AddMemberWorkspaceRequest $request)
    {
        $data = $this->workSpaceInfoService->addMembers($id, $request);
        return $this->json(['data' => $data]);
    }

    /**
     * update current workspace
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function switchWorkspace(Request $request)
    {
        $data = $this->workSpaceInfoService->switchWorkspace($request);
        return $this->json(['data' => $data]);
    }

    /**
     * detach user in teamwork
     *
     * Xóa user khỏi nhóm
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function detachTeamWork($id, Request $request)
    {
        $this->workSpaceInfoService->detachTeamWork($id, $request);

        return response()->json(['success' => true]);
    }

    /**
     * Chi tiết workspace info
     *
     * Display a listing of the resource.
     * @param int $id
     * @return Response
     */
    public function getWorkspaceInfo($id)
    {
        $data = $this->workSpaceInfoService->find($id)->load('team.quizSchoolLevels');
        return $this->json(['data' => $data]);
    }

}
