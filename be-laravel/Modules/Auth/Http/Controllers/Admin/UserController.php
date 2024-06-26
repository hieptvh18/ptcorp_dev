<?php

namespace Modules\Auth\Http\Controllers\Admin;

use App\Exports\Admin\UserExportFile;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Services\UserService;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\UserInfoService;
use Illuminate\Contracts\Support\Renderable;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Http\Requests\AdminUserCreateRequest;
use Modules\Auth\Http\Requests\AdminUserUpdateRequest;
use Modules\Auth\Http\Requests\AdminResetPasswordRequest;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup User Management
 * @subgroupDescription UserController
 */
class UserController extends ApiController
{
    protected $userService;
    protected $userInfoService;

    /**
     * Class constructor.
     */
    public function __construct(UserService $userService, UserInfoService $userInfoService)
    {
        $this->userService = $userService;
        $this->userInfoService = $userInfoService;
    }

    /**
     * Lấy danh sách users
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->userService->getList($request);
        if ($request->has('export')) {
            // dd($data->items());
            $export = new UserExportFile($data);
            return Excel::download($export, 'users.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }
        return $this->json($data);
    }

    /**
     * Tạo mới user
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(AdminUserCreateRequest $request)
    {
        $item = $this->userService->create($request);
        return $this->json(['data' => $item]);
    }

    /**
     * Lấy chi tiết user
     *
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $item = $this->userService->find($id);
        return $this->json(['data' => $item]);
    }

    /**
     * Block user
     *
     * @param int $id
     * @return Renderable
     */
    public function blockUser($id)
    {
        $user = $this->userService->blockUser($id);
        return $this->json(['data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(AdminUserUpdateRequest $request, $id)
    {
        $data = $this->userService->update($request, $id);
        return $this->json([
            'data' => $data
        ]);
    }

    /**
     * Xoá user
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $deleted = $this->userService->delete($id);
        return $this->json(['success' => $deleted]);
    }

    /**
     * Thống kê loại user
     *
     * Remove the specified resource from storage.
     * @param Request $request
     * @return Renderable
     */
    public function statisUserType(Request $request)
    {
        $data = $this->userInfoService->statisUserTypeByMonth($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function resetPasswordUser(AdminResetPasswordRequest $request, $id)
    {
        $data = $this->userService->resetPasswordUser($request, $id);

        return response()->json([
            'message' => __('auth::message.password.update_success'),
            'data' => $data
        ]);
    }

    /**
     * UnBlock user
     *
     * @param int $id
     * @return Renderable
     */
    public function unBlockUser($id)
    {
        $user = $this->userService->unBlockUser($id);
        return $this->json(['data' => $user]);
    }

    /**

     * UnBlock user all 
     * 
     * @param int $id 
     * @return Renderable 
     */ 
    public function unBlockUserAll(Request $request) 
    { 
        $user = $this->userService->unBlockUserAll($request); 
        return $this->json(['data' => $user]); 
    } 


     /* Admin thống kê user tạo mới trong tháng so với tháng trước
     *
     * Display a listing of the resource.
     * @queryParam month string. Example : 01
     * @queryParam year string. Example : 2020
     * @return Renderable
     */
    public function statisUserRegisters(Request $request)
    {
        $data = $this->userService->statisUserRegister($request);
        return $this->json(['data' => $data]);
    }
}

