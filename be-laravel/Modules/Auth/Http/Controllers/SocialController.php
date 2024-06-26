<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Modules\Auth\Services\SocialService;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup Social Login
 * @subgroupDescription AuthController
 */
class SocialController extends ApiController
{
    protected $socialService;
    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }
    /**
     * Đăng nhập bằng mạng xã hội
     *
     * @param  $provider
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginSocial(Request $request, $provider)
    {
        $data = $this->socialService->login($request, $provider);
        return $this->json($data, 200);
    }
}
