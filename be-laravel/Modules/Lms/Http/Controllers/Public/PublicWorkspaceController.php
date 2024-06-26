<?php

namespace Modules\Lms\Http\Controllers\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Services\Public\PublicWorkspaceService;

/**
 * @group Module Lms
 *
 * APIs for managing public workspace
 *
 * @subgroup Workspace Public
 * @subgroupDescription PublicWorkspaceController
 */
class PublicWorkspaceController extends ApiController
{
    protected $publicWorkspaceService;

    public function __construct(PublicWorkspaceService $publicWorkspaceService)
    {
        $this->publicWorkspaceService = $publicWorkspaceService;
    }

    /**
     * public run migration
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function runMigration(Request $request)
    {
        $item = $this->publicWorkspaceService->runMigration($request);
        return $this->json($item);
    }

    /**
     * public thêm thành viên
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function addMember(Request $request)
    {
        $item = $this->publicWorkspaceService->addMember($request);
        return $this->json($item);
    }

    /**
     * public đồng bộ trình độ
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function syncSchoolLevel(Request $request)
    {
        $item = $this->publicWorkspaceService->syncSchoolLevel($request);
        return $this->json($item);
    }

    /**
     * public đồng bộ thành viên
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function syncMemberAdmin(Request $request)
    {
        $item = $this->publicWorkspaceService->syncMemberAdmin($request);
        return $this->json($item);
    }

    /**
     * public xóa thành viên khỏi workspace
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function removeMemberInWorkspace(Request $request)
    {
        $item = $this->publicWorkspaceService->removeMemberInWorkspace($request);
        return $this->json($item);
    }
}
