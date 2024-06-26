<?php

namespace Modules\Auth\Services;

use App\Exceptions\ApiException;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

use Modules\Auth\Enums\UserInfoType;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Models\Sanctum\PersonalAccessToken;
use Modules\Quiz\Models\ExamChanel;
use Modules\Core\Traits\CoreEmailSetting;

class AuthService
{
    use CoreEmailSetting;

    public function register(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($request->password),
            ]);
            $user->info()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'type' => $request->input('user_type') ?? UserInfoType::STUDENT,
                'custom_data' => $request->input('custom_data') ?? null
            ]);
            ExamChanel::create(
                [
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'status' => 'PUBLISH',
                    'created_by' => $user->id,
                    'user_id' => $user->id
                ]
            );
            $this->setEmailBySetting();
            event(new Registered($user));
            DB::commit();
            return $user;
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function loginCreateToken(LoginRequest $request)
    {
        try {
            $request->ensureIsNotRateLimited();
            $remember = $request->boolean('remember');
            $credential = [
                'password' => $request->password
            ];
            if ($request->has('username')) {
                $credential['username'] = $request->username;
            } elseif ($request->has('email')) {
                $credential['email'] = $request->email;
            } elseif ($request->has('mobile')) {
                $credential['mobile'] = $request->mobile;
            }

            if (!Auth::attempt($credential, $remember)) {
                RateLimiter::hit($request->throttleKey());
                throw new ApiException('Tài khoản hoặc mất khẩu không đúng', 401);
            }
            RateLimiter::clear($request->throttleKey());
            // $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status === 'BLOCKED') {
                RateLimiter::hit($request->throttleKey());
                throw new ApiException('Tài khoản của bạn đã bị khóa', 401);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];

            return $data;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function forgotPassword(Request $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
        return $status;
    }

    public function resetPassword(Request $request)
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
        return $status;
    }

    public function verifyEmail(Request $request)
    {
        try {
            $user = $request->user();
            if ($user->hasVerifiedEmail()) {
                throw new ApiException('Email này đã được xác thực', 500);
            }
            $code = $request->input('code');
            if ($user->verifyCode($code)) {
                if ($user->markEmailAsVerified()) {
                    $this->setEmailBySetting();
                    event(new Verified($request->user()));
                }
            } else {
                throw new ApiException('Mã xác thực không đúng!', 500);
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function loginAdminCreateToken(LoginRequest $request)
    {
        try {
            $request->ensureIsNotRateLimited();
            $remember = $request->boolean('remember');
            $credential = [
                'password' => $request->password
            ];
            if ($request->has('username')) {
                $credential['username'] = $request->username;
            } elseif ($request->has('email')) {
                $credential['email'] = $request->email;
            } elseif ($request->has('mobile')) {
                $credential['mobile'] = $request->mobile;
            }
            if (!Auth::attempt($credential, $remember)) {
                RateLimiter::hit($request->throttleKey());
                throw new Exception('Tài khoản hoặc mất khẩu không đúng', 401);
            }

            // $request->session()->regenerate();
            $user = Auth::user();
            if ($user->info->type !== 'ADMIN') {
                throw new Exception('Tài khoản không phải là tài khoản Admin', 401);
            }
            RateLimiter::clear($request->throttleKey());
            $token = $user->createToken('authToken')->plainTextToken;

            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer'
            ];

            return $data;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Admin login user
     *
     * @param Request $request
     * @return void
     */
    public function loginUserByAdmin(Request $request)
    {
        $user_id = $request->input('user_id');
        $admin_token = $request->input('admin_token');
        $admin = PersonalAccessToken::findToken($admin_token);
        if ($admin) {
            $admin_user = User::find($admin->tokenable_id);
            if ($admin_user->info->type === 'ADMIN') {
                auth()->loginUsingId($user_id);
                $user = Auth::user();
                $token = $user->createToken('authToken')->plainTextToken;

                $data = [
                    'access_token' => $token,
                    'token_type' => 'Bearer'
                ];
                return $data;
            }
        }
        throw new Exception('Tài khoản không phải là tài khoản Admin', 401);
    }
}
