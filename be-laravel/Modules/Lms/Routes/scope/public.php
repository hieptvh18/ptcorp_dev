<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\Public\PublicWorkspaceController;


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
    'name' => 'public.'
], function () {

    Route::controller(PublicWorkspaceController::class)->group(function () {
        Route::post('run-migration', 'runMigration')->name('lms.public.runMigration');
        Route::post('add-member', 'addMember')->name('lms.public.addMember');
        Route::post('sync-school-level', 'syncSchoolLevel')->name('lms.public.syncSchoolLevel');
        Route::post('sync-member-admin', 'syncMemberAdmin')->name('lms.public.syncMemberAdmin');
        Route::post('remove-member-workspace', 'removeMemberInWorkspace')->name('lms.public.removeMemberInWorkspace');
    });
});
