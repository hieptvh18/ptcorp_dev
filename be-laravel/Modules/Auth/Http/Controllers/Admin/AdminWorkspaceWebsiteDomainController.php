<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Auth\Http\Requests\WorkspaceWebsiteCreateRequest;
use Modules\Auth\Http\Requests\WorkspaceWebsiteUpdateRequest;
use Modules\Auth\Http\Requests\WorkspaceWebsiteDomainCreateRequest;
use Modules\Auth\Http\Requests\WorkspaceWebsiteDomainUpdateRequest;
use Modules\Auth\Services\Admin\AdminWorkspaceWebsiteDomainService;

/**
 * @group Module Auth
 *
 * APIs for managing workspace website domain
 *
 * @subgroup Admin Workspace website domain
 * @subgroupDescription AdminWorkspaceWebsiteController
 */
class AdminWorkspaceWebsiteDomainController extends ApiController
{

    protected $workspaceWebsiteDomainService;

    public function __construct(AdminWorkspaceWebsiteDomainService $workspaceWebsiteDomainService)
    {
        $this->workspaceWebsiteDomainService = $workspaceWebsiteDomainService;
    }

    /**
     * Danh sách workspace website domain
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->workspaceWebsiteDomainService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * thêm workspace website domain
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(WorkspaceWebsiteDomainCreateRequest $request)
    {
        $item = $this->workspaceWebsiteDomainService->create($request);
        $data = [
            'message' => __('auth::message.workspace_website.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * chi tiết workspace website domain
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->workspaceWebsiteDomainService->find($id)->with('website');
        return $this->json(['data' => $data]);
    }

    /**
     * sửa workspace website domain
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(WorkspaceWebsiteDomainUpdateRequest $request, $id)
    {
        $item = $this->workspaceWebsiteDomainService->update($request, $id);
        $data = [
            'message' => __('auth::message.workspace_website_domain.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * xóa workspace website domain
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->workspaceWebsiteDomainService->delete($id);
        $data = [
            'message' => __('auth::message.workspace_website_domain.delete_success'),
        ];
        return $this->json($data);
    }
}
