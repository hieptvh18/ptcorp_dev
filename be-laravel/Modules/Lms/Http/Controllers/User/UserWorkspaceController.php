<?php

namespace Modules\Lms\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Services\User\UserWorkspaceService;
use Modules\Lms\Services\WorkspaceService;

/**
 * @group Module Lms
 *
 * APIs for managing workspace
 *
 * @subgroup Workspace
 * @subgroupDescription UserWorkspaceController
 */
class UserWorkspaceController extends ApiController
{
    protected $workspaceService;
    public function __construct(UserWorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    /**
     * lấy ra workspace hiện tại
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function getCurrentWorkspace(Request $request)
    {
        $data = $this->workspaceService->getCurrentWorkspace($request);
        return $this->json(['data' => $data]);
    }

    // /**
    //  * update current workspace
    //  *
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function switchWorkspace(Request $request)
    // {
    //     $data = $this->workspaceService->switchWorkspace($request);
    //     return $this->json(['data' => $data]);
    // }

    /**
     * List members of workspace
     *
     * Danh sách thành viên
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function teamWorkMembers($id, Request $request)
    {
        $data = $this->workspaceService->teamWorkMembers($id, $request);

        return response()->json($data);
    }

    /**
     * My role
     *
     * Display a listing of the resource.
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function myRole($id, Request $request)
    {
        $data = $this->workspaceService->myRole($id, $request);
        return $this->json(['data' => $data]);
    }
}
