<?php

namespace Modules\Auth\Http\Controllers\Admin;

use Modules\Auth\Services\AuthService;
use App\Http\Controllers\ApiController;
use Modules\Auth\Http\Requests\LoginRequest;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup Admin Authentication
 * @subgroupDescription AdminLoginController
 */
class AdminLoginController extends ApiController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    /**
     * Login
     *
     * Admin đăng nhâp
     * @param  \Modules\Auth\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $data = $this->authService->loginAdminCreateToken($request);
        return $this->json($data, 200);
    }

}
