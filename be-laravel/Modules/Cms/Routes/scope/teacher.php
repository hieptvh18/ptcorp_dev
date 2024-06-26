<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\Teacher\TeacherWorkspaceController;

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
    'name' => 'teacher.'
], function () {
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function () {
        
    });
});
