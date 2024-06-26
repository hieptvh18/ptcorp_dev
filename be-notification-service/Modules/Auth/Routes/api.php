<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\SocialController;
use Modules\Auth\Http\Controllers\UserInfoController;
use Modules\Auth\Http\Controllers\Admin\RoleController;
use Modules\Auth\Http\Controllers\Admin\UserController;
use Modules\Auth\Http\Controllers\Admin\AdminLoginController as LoginAdminController;
use Modules\Auth\Http\Controllers\Admin\PermissionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1'
], function () {

    Route::post('login/{provider}', [SocialController::class, 'loginSocial'])->name('login.social');

    Route::controller(AuthController::class)->group(function () {
        Route::post('login-by-admin', 'loginUserByAdmin')->name('auth.loginUserByAdmin');
        Route::middleware('guest')->group(function () {
            Route::post('register', 'register')->name('auth.register');
            Route::post('login', 'login')->name('auth.login');
            Route::post('forgot-password', 'forgotPassword')->name('auth.forgotPassword');
            Route::post('reset-password', 'resetPassword')->name('auth.resetPassword');
        });


        Route::middleware('auth:sanctum')->group(function () {
            Route::get('me', 'me')->name('auth.me');
            Route::get('notifications', 'getUserNotification')->name('auth.getUserNotification');
            Route::get('read-notifications', 'readNotifications')->name('auth.readNotifications');
            Route::post('logout', 'logout')->name('auth.logout');
            Route::post('verify-email', 'verifyEmail')
                ->middleware(['throttle:6,1'])
                ->name('auth.verifyEmail');
            Route::post('resent-verify-code', 'resentVerifyEmailCode')
                ->middleware(['throttle:6,1'])
                ->name('auth.resentVerifyEmailCode');
            Route::get('user-point', 'getPointUser')->name('auth.getPointUser');
        });
    });

    Route::prefix('user')->controller(UserInfoController::class)->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::put('info', 'updateUserInfo')->name('userInfo.update');
            Route::put('change-password', 'changePassword')->name('user.changePassword');
        });
    });

    // for admin
    Route::group([
        'prefix' => 'admin',
    ], function () {

        Route::post('login', [LoginAdminController::class, 'login'])->name('admin.login');

        Route::middleware('auth:sanctum')->group(function () {

            Route::controller(UserController::class)->group(function () {
                Route::post('users/unblock-by-date', 'unBlockUserAll')->name('admin.users.unblockUserAll');
                Route::patch('users/{item}/block', 'blockUser')->name('users.blockUser');
                Route::get('statis-user-type', 'statisUserType')->name('users.statisUserType');
                Route::post('users/{item}/unblock', 'unBlockUser')->name('admin.users.unblockUser');
                Route::get('statis-user-register', 'statisUserRegisters')->name('admin.users.statisUserRegisters');
            });
            Route::apiResource('users', UserController::class);
            Route::apiResource('roles', RoleController::class);
            Route::apiResource('permissions', PermissionController::class);
            Route::post('users/{item}/reset-password', [UserController::class, 'resetPasswordUser'])->name('admin.resetPassword');
        });
    });
});
