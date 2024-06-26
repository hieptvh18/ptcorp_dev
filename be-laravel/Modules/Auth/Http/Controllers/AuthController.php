<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

use Modules\Quiz\Models\ExamChanel;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Cache;
use Modules\Auth\Services\AuthService;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Password;

use Modules\Auth\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\LoginByAdminRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Models\Sanctum\PersonalAccessToken;
use Modules\Auth\Http\Requests\EmailVerificationRequest;
use Modules\Core\Models\RewardPoint;

/**
 * @group Module Auth
 *
 * APIs for managing users
 *
 * @subgroup User Authentication
 * @subgroupDescription AuthController
 */
class AuthController extends ApiController
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register
     *
     * User đăng ký tài khoản
     * @param RegisterRequest $request
     * @return void
     */
    public function register(RegisterRequest $request)
    {

        $this->authService->register($request);

        return response()->json(['success' => true], 200);
    }

    /**
     * Login
     *
     * User đăng nhâp
     * @param  \Modules\Auth\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $data = $this->authService->loginCreateToken($request);
        return $this->json($data, 200);
    }

    /**
     * Get user info logged
     *
     * Lấy thông tin tài khoản đăng nhập
     * @param Request $request
     * @return void
     */
    public function me(Request $request)
    {
        $user = $request->user();
        if ($user->userInfoQuiz) {
            $has_quiz_info = true;
        } else {
            $has_quiz_info = false;
        }
        $user->has_quiz_info = $has_quiz_info;

        $user['user_chanel'] = Cache::remember('me-chanel-' . $user->id, 36000, function () use ($user) {
            return $user->chanel;
        });
        if (!$user->chanel) {
            $user['user_chanel'] = Cache::remember('me-chanel-' . $user->id, 36000, function () use ($user) {
                return  ExamChanel::select('id', 'name')->where('created_by', $user->id)->first();
            });
        }
        $user->notication_unread_count = $user->unreadNotifications()->count();
        return $this->json(['data' => $user]);
    }

    /**
     * Forgot password
     *
     * User quên mật khẩu
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = $this->authService->forgotPassword($request);

        return $this->json(['message' => __($status)]);
    }

    /**
     * Reset password
     *
     * User reset mật khẩu
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(ResetPasswordRequest $request)
    {

        $status = $this->authService->resetPassword($request);

        return response()->json(['message' => __($status)]);
    }

    /**
     * Verify email by code
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $status = $this->authService->verifyEmail($request);
        return response()->json(['status' => $status]);
    }


    /**
     * Send verify code to email user
     *
     *
     * @param Request $request
     * @return void
     */
    public function resentVerifyEmailCode(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            abort(403);
        }

        $this->setEmailBySetting();
        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => true]);
    }

    /**
     * Logout
     *
     * User đăng xuất
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $logout = $request->user()->currentAccessToken()->delete();
        return $this->json(['success' => $logout]);
    }

    /**
     * User get notification
     *
     * @param Request $request
     * @return void
     */
    public function getUserNotification(Request $request)
    {
        $user = $request->user();
        $is_unread = $request->query('is_unread');
        if ($is_unread == 1) {
            $data = $user->unreadNotifications()->paginate();
            return $this->json(['data' => $data]);
        }
        $data = $user->notifications()->paginate();
        return $this->json($data);
    }

    /**
     * User read notification
     *
     * @param Request $request
     * @return void
     */
    public function readNotifications(Request $request)
    {
        $user = $request->user();
        $user->unreadNotifications->markAsRead();
        return $this->json(['success' => true]);
    }

    /**
     * Admin login user
     *
     * @param Request $request
     * @return void
     */
    public function loginUserByAdmin(LoginByAdminRequest $request)
    {
        $data = $this->authService->loginUserByAdmin($request);
        return $this->json($data, 200);
    }

    /**
     * Get point user
     *
     * @param Request $request
     * @return void
     */
    public function getPointUser(Request $request)
    {
        $user = auth()->user();
        $user_reward_point = RewardPoint::where('user_id', $user->id)->first();
        if (!$user_reward_point) {
            $new_user_reward_point = RewardPoint::create([
                'user_id' => $user->id,
                'reward_point' => 0
            ]);

            $reward_point = $new_user_reward_point->reward_point;
        } else {
            $reward_point = $user_reward_point->reward_point;
        }
        $data = [
            'point' => $reward_point
        ];
        return $this->json(['data' => $data]);
    }
}
