<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\User\UserWorkspaceController;

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
    'prefix' => 'v1',
    'name' => 'user.'
], function () {
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::controller(UserWorkspaceController::class)->group(function () {
            Route::get('current-workspace', 'getCurrentWorkspace')->name('lms.user.getCurrentWorkspace');
            // Route::post('switch-workspace', 'switchWorkspace')->name('lms.user.switchWorkspace');
            Route::get('teamworks/{id}/members', 'teamWorkMembers')->name('lms.user.teamWorkMembers');
            // Route::post('teamworks/{id}/members/{user_id}/left-team', 'detachTeamWork')->name('lms.user.detachTeamWork');
            // Route::get('teamworks/{id}/workspace-info', 'getWorkspaceInfo')->name('lms.user.getWorkspaceInfo');
            Route::get('teamworks/{id}/my-role', 'myRole')->name('lms.user.myRole');
        });

    });
});
