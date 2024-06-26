<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Auth\Http\Requests\WorkspaceWebsiteCreateRequest;
use Modules\Auth\Http\Requests\WorkspaceWebsiteUpdateRequest;
use Modules\Auth\Services\Admin\AdminWorkspaceWebsiteService;

/**
 * @group Module Auth
 *
 * APIs for managing workspace website
 *
 * @subgroup Admin Workspace website
 * @subgroupDescription AdminWorkspaceWebsiteController
 */
class AdminWorkspaceWebsiteController extends ApiController
{

    protected $workspaceWebsiteService;

    public function __construct(AdminWorkspaceWebsiteService $workspaceWebsiteService)
    {
        $this->workspaceWebsiteService = $workspaceWebsiteService;
    }

    /**
     * Danh sách workspace website
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->workspaceWebsiteService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * thêm workspace website
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(WorkspaceWebsiteCreateRequest $request)
    {
        $item = $this->workspaceWebsiteService->create($request);
        $data = [
            'message' => __('auth::message.workspace_website.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * chi tiết workspace website
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->workspaceWebsiteService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * sửa workspace website
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(WorkspaceWebsiteUpdateRequest $request, $id)
    {
        $item = $this->workspaceWebsiteService->update($request, $id);
        $data = [
            'message' => __('auth::message.workspace_website.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * xóa workspace website
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->workspaceWebsiteService->delete($id);
        $data = [
            'message' => __('auth::message.workspace_website.delete_success'),
        ];
        return $this->json($data);
    }

    /**
     * lấy workspace website domain
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function getWPWebsiteDomain($website_id)
    {
        $data = $this->workspaceWebsiteService->getWPWebsiteDomain($website_id);
        return $this->json(['data' => $data], 200);
    }
}
