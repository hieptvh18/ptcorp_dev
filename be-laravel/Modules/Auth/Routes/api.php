<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\SocialController;
use Modules\Auth\Http\Controllers\UserInfoController;
use Modules\Auth\Http\Controllers\Admin\RoleController;
use Modules\Auth\Http\Controllers\Admin\UserController;
use Modules\Auth\Http\Controllers\User\TeamWorkController;
use Modules\Auth\Http\Controllers\Admin\PermissionController;
use Modules\Auth\Http\Controllers\User\WorkspaceInfoController;
use Modules\Auth\Http\Controllers\User\TeamWorkMemberController;
use Modules\Auth\Http\Controllers\Admin\AdminWorkspaceInfoController;
use Modules\Auth\Http\Controllers\Admin\AdminWorkspaceWebsiteController;
use Modules\Auth\Http\Controllers\User\RoleController as UserRoleController;
use Modules\Auth\Http\Controllers\Admin\AdminWorkspaceWebsiteDomainController;
use Modules\Auth\Http\Controllers\Admin\AdminLoginController as LoginAdminController;

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

    Route::group([
        'prefix' => 'user',
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::controller(UserInfoController::class)->group(function () {
            Route::put('info', 'updateUserInfo')->name('userInfo.update');
            Route::put('change-password', 'changePassword')->name('user.changePassword');
        });

        Route::controller(TeamWorkController::class)->group(function () {
            Route::get('teamworks', 'joinedTeamWorks')->name('user.joinedTeamWorks');
            Route::get('teamworks/my-invited', 'myInvited')->name('user.myInvited');
            Route::post('teamworks/{id}/invite', 'inviteTeamWork')->name('user.inviteTeamWork');
            Route::post('teamworks/{id}/accept/{token}', 'acceptInvite')->name('user.acceptInvite');
            Route::post('teamworks/{id}/deny/{token}', 'denyInvite')->name('user.denyInvite');
            Route::post('teamworks/{id}/invited/{id_invite}/cancel-invitaion', 'cancelInvitation')->name('user.cancelInvitation');
        });

        Route::controller(TeamWorkMemberController::class)->group(function () {
            Route::get('teamworks/{id}/members', 'teamWorkMembers')->name('user.teamWorkMembers');
            Route::get('teamworks/{id}/members/invited', 'invitedMembers')->name('user.invitedMembers');
            Route::get('teamworks/{id}/members/{id_member}', 'findMember')->name('user.findMember');
            Route::post('teamworks/{id}/members/remove-user-team', 'detachTeamWork')->name('user.remove-user-team');
        });

        Route::controller(WorkspaceInfoController::class)->group(function () {
            Route::post('workspace-info', 'store')->name('user.workspace-info.store');
            Route::put('workspace-info/{id}', 'update')->name('user.workspace-info.update');
            Route::get('my-workspace-info', 'getMyAccessWorkspace')->name('user.getMyAccessWorkspace');
            Route::post('teamworks/{id}/add-member', 'addMembers')->name('user.addMembers');
            Route::post('switch-workspace', 'switchWorkspace')->name('user.switchWorkspace');
            Route::post('teamworks/{id}/members/left-team', 'detachTeamWork')->name('user.left-team');
            Route::get('workspace-info/{id}', 'getWorkspaceInfo')->name('user.getWorkspaceInfo');
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
            Route::post('permissions/save-group-permission', [PermissionController::class, 'saveGroupPermission'])->name('admin.saveGroupPermission');
            Route::apiResource('permissions', PermissionController::class);

            Route::post('users/{item}/reset-password', [UserController::class, 'resetPasswordUser'])->name('admin.resetPassword');
            Route::controller(AdminWorkspaceWebsiteController::class)->group(function () {
                Route::get('workspace-website', 'index')->name('admin.workspace-website.index');
                Route::get('workspace-website/{id}', 'show')->name('admin.workspace-website.show');
                Route::post('workspace-website', 'store')->name('admin.workspace-website.store');
                Route::put('workspace-website/{id}', 'update')->name('admin.workspace-website.update');
                Route::delete('workspace-website/{id}', 'destroy')->name('admin.workspace-website.destroy');
                Route::get('workspace-website/{id}/workspace-website-domains', 'getWPWebsiteDomain')->name('admin.workspace-website.getWPWebsiteDomain');
            });

            Route::controller(AdminWorkspaceWebsiteDomainController::class)->group(function () {
                Route::get('workspace-website-domains', 'index')->name('admin.workspace-website-domains.index');
                Route::get('workspace-website-domains/{id}', 'show')->name('admin.workspace-website-domains.show');
                Route::post('workspace-website-domains', 'store')->name('admin.workspace-website-domains.store');
                Route::put('workspace-website-domains/{id}', 'update')->name('admin.workspace-website-domains.update');
                Route::delete('workspace-website-domains/{id}', 'destroy')->name('admin.workspace-website-domains.destroy');
            });

            Route::controller(AdminWorkspaceInfoController::class)->group(function () {
                Route::get('workspace-info', 'index')->name('admin.workspace-info.index');
            });
        });
    });
});
