<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\RoleCreateRequest;
use Modules\Auth\Http\Requests\RoleUpdateRequest;
use Modules\Auth\Services\RoleService;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup Role Management
 * @subgroupDescription RoleController
 */
class RoleController extends ApiController
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Lấy danh sách role
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->roleService->getList($request);
        return $this->json($data);
    }

    /**
     * Tạo mới role
     *
     * Store a newly created resource in storage.
     * @param RoleCreateRequest $request
     * @return Response
     */
    public function store(RoleCreateRequest $request)
    {
        $item = $this->roleService->create($request);
        return $this->json(['data' => $item]);
    }

    /**
     * Lấy chi tiết role
     *
     * Show the specified resource.
     * @urlParam id integer required The ID of the role. Example: 1
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->roleService->find($id);
        return $this->json(['data' => $item]);
    }

    /**
     * Cập nhật role
     *
     * Update the specified resource in storage.
     * @param RoleUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $item = $this->roleService->update($request, $id);
        return $this->json(['data' => $item]);
    }

    /**
     * Xoá role
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->roleService->delete($id);
        return $this->json(['data' => [
            'success' => $deleted
        ]]);
    }
}
