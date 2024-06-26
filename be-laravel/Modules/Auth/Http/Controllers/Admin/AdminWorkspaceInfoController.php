<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\Admin\AdminWorkspaceInfoService;

/**
 * @group Module Auth
 *
 * APIs for managing workspace info
 *
 * @subgroup Admin Workspace info
 * @subgroupDescription AdminWorkspaceInfoController
 */
class AdminWorkspaceInfoController extends ApiController
{

    protected $workspaceInfoService;

    public function __construct(AdminWorkspaceInfoService $workspaceInfoService)
    {
        $this->workspaceInfoService = $workspaceInfoService;
    }

    /**
     * Danh sách workspace Info
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->workspaceInfoService->getList($request);
        return $this->json($data, 200);
    }
}
