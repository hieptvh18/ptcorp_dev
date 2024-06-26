<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\Member\MemberController;

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
     'name' => 'member.'
 ], function () {
     Route::group(['middleware'=>'auth:sanctum'],function (){
         Route::controller(MemberController::class)->group(function (){
             Route::get('members/{member_id}/exam-rooms', 'getMemberExamRooms')->name('lms.member.getMemberExamRooms');
         });
     });
 });
