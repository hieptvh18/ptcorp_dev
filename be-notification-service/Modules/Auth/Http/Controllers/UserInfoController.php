<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\UserInfoService;
use Modules\Auth\Http\Requests\UserInfoUpdateRequest;
use Modules\Auth\Http\Requests\UserChangePasswordRequest;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup User Authentication
 * @subgroupDescription UserInfoController
 */
class UserInfoController extends ApiController
{
    protected $userInfoService;

    public function __construct(UserInfoService $userInfoService)
    {
        $this->userInfoService = $userInfoService;
    }

    public function updateUserInfo(UserInfoUpdateRequest $request)
    {
        $data = $this->userInfoService->updateInfo($request);
        return $this->json([
            'message' => __('auth::message.user_info.update_success'),
            'data' => $data
        ]);
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $data = $this->userInfoService->changePassword($request);
        return $this->json([
            'message' => __('auth::message.password.update_success'),
        ], 200);
    }
}
