<?php

namespace Modules\Lms\Http\Controllers\Teacher;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Services\Admin\AdminWorkspaceService;
use Modules\Auth\Http\Requests\ChangeRoleWorkspaceRequest;
use Modules\Lms\Services\Teacher\TeacherWorkspaceService;

/**
 * @group Module Lms
 *
 * APIs for managing teacher workspace
 *
 * @subgroup Workspace teacher
 * @subgroupDescription TeacherWorkspaceController
 */
class TeacherWorkspaceController extends ApiController
{
    protected $workspaceService;

    public function __construct(TeacherWorkspaceService $workspaceService)
    {
        $this->workspaceService = $workspaceService;
    }

    /**
     * get role
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function lmsGetRole(Request $request)
    {
        $data = $this->workspaceService->lmsGetRole($request);
        return $this->json($data);
    }
}
