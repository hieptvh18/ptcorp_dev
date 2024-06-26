<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\Admin\AdminClassRoomController;
use Modules\Lms\Http\Controllers\Admin\AdminMemberController;
use Modules\Lms\Http\Controllers\Admin\AdminSchoolYearController;
use Modules\Lms\Http\Controllers\Admin\AdminWorkspaceController;
use Modules\Lms\Http\Controllers\Admin\AdminNotificationConfigController;
use Modules\Lms\Http\Controllers\Admin\AdminExamRoomController;
use Modules\Lms\Http\Controllers\Admin\AdminSubjectController;
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
    'name' => 'admin.'
], function () {
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::controller(AdminWorkspaceController::class)->group(function () {
            Route::get('workspaces/workspace-statis', 'workspaceStatistical')->name('lms.admin.workspaceStatistical');
            Route::post('workspaces/change-role', 'changeRole')->name('user.changeRole');
            Route::get('workspaces/notifications', 'workspaceNotification')->name('lms.admin.workspaceNotification');
            Route::get('workspaces/events', 'workspaceEvent')->name('lms.admin.workspaceEvent');
            Route::get('workspaces/members', 'workspaceMember')->name('lms.admin.workspaceMember');
            Route::get('workspaces/classrooms', 'workspaceClassroom')->name('lms.admin.workspaceClassroom');
            Route::get('workspaces/training-program', 'workspaceTrainingProgram')->name('lms.admin.workspaceTrainingProgram');
            Route::put('workspaces/{item}/update', 'updateWorkSpace')->name('lms.admin.updateWorkSpace');
            Route::post('workspaces/{id}/members/detach-team', 'detachTeamWork')->name('lms.admin.detachTeamWork');
        });

        Route::controller(AdminClassRoomController::class)->group(function () {
            Route::post('classrooms', 'saveClassroom')->name('lms.admin.classroom.saveClassroom');
            Route::put('classrooms/{id}', 'updateClassroom')->name('lms.admin.classroom.updateClassroom');
            Route::post('search-classroom', 'searchClassroom')->name('lms.admin.searchClassroom');
            Route::post('delete-classroom', 'deleteClassroom')->name('lms.admin.classroom.deleteClassroom');
            Route::post('classrooms/{classroom_id}/note', 'noteClassroom')->name('lms.admin.classroom.noteClassroom');
        });

        Route::controller(AdminMemberController::class)->group(function () {
            Route::post('members/assign-classroom', 'assignClassroom')->name('lms.admin.member.assignClassroom');
            Route::post('members/move-classroom', 'moveClassroom')->name('lms.admin.member.moveClassroom');
            Route::post('members', 'createMember')->name('lms.admin.member.createMember');
            Route::post('members/remove-from-classroom', 'removeFromClassroom')->name('lms.admin.member.removeFromClassroom');
            Route::get('members/{member_id}', 'findMember')->name('lms.admin.member.findMember');
        });

        Route::controller(AdminSchoolYearController::class)->group(function () {
            Route::get('school-years', 'index')->name('lms.admin.school-years.index');
            Route::get('school-years/{id}', 'show')->name('lms.admin.school-years.show');
            Route::post('school-years', 'store')->name('lms.admin.school-years.store');
            Route::put('school-years/{id}', 'update')->name('lms.admin.school-years.update');
            Route::delete('school-years/{id}', 'destroy')->name('lms.admin.school-years.destroy');
        });

        Route::controller(AdminNotificationConfigController::class)->group(function(){
            Route::get('notifications/configs','index')->name('lms.admin.notificationConfig.index');
            Route::get('notifications/configs/{config_id}','show')->name('lms.admin.notificationConfig.show');
            Route::post('notifications/configs','store')->name('lms.admin.notificationConfig.store');
            Route::put('notifications/configs/{config_id}','update')->name('lms.admin.notificationConfig.update');
            Route::delete('notifications/configs/{config_id}','destroy')->name('lms.admin.notificationConfig.destroy');
        });

        Route::controller(AdminExamRoomController::class)->group(function(){
            Route::get('exam-rooms','index')->name('lms.admin.exam_room.index');
            Route::get('exam-rooms/{id}','show')->name('lms.admin.exam_room.show');
            Route::post('exam-rooms','store')->name('lms.admin.exam_room.store');
            Route::put('exam-rooms/{id}','update')->name('lms.admin.exam_room.update');
            Route::delete('exam-rooms/{id}','destroy')->name('lms.admin.exam_room.destroy');
            Route::get('exam-rooms-by-ids','getExamRoomByIds')->name('lms.admin.exam_room.getExamRoomByIds');
        });

        Route::controller(AdminSubjectController::class)->group(function(){
            Route::get('subjects','index')->name('lms.admin.subjects.index');
            Route::get('subjects/{id}','show')->name('lms.admin.subjects.show');
            Route::post('subjects','store')->name('lms.admin.subjects.store');
            Route::put('subjects/{id}','update')->name('lms.admin.subjects.update');
            Route::delete('subjects/{id}','destroy')->name('lms.admin.subjects.destroy');
        });
    });
});
