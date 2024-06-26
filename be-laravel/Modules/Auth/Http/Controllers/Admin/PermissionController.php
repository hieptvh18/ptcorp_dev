<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\PermissionCreateRequest;
use Modules\Auth\Http\Requests\PermissionUpdateRequest;
use Modules\Auth\Http\Requests\RoleCreateRequest;
use Modules\Auth\Http\Requests\RoleUpdateRequest;
use Modules\Auth\Services\PermissionService;
use Modules\Auth\Services\RoleService;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup Permission Management
 * @subgroupDescription PermissionController
 */
class PermissionController extends ApiController
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Lấy danh sách permission
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->permissionService->getList($request);
        return $this->json($data);
    }

    /**
     * Lưu nhóm quyền
     *
     * Store a newly created resource in storage.
     * @param PermissionCreateRequest $request
     * @return Response
     */
    public function saveGroupPermission(PermissionCreateRequest $request)
    {
        $item = $this->permissionService->saveGroupPermission($request);
        return $this->json(['success' => $item]);
    }

    /**
     * Lấy chi tiết permissoin
     *
     * Show the specified resource.
     * @urlParam id integer required The ID of the role. Example: 1
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->permissionService->find($id);
        return $this->json(['data' => $item]);
    }

    // /**
    //  * Cập nhật permissoin
    //  *
    //  * Update the specified resource in storage.
    //  * @param PermissionUpdateRequest $request
    //  * @param int $id
    //  * @return Response
    //  */
    // public function update(PermissionUpdateRequest $request, $id)
    // {
    //     $item = $this->permissionService->update($request, $id);
    //     return $this->json(['data' => $item]);
    // }

    /**
     * Xoá permissoin
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->permissionService->delete($id);
        return $this->json(['data' => [
            'success' => $deleted
        ]]);
    }
}
