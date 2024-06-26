<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lms\Http\Controllers\LmsUploadController;
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

// Route::middleware('auth:api')->get('/', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group([
        'middleware' => ['auth:sanctum', 'workspace_db']
    ], function () {
        Route::controller(LmsUploadController::class)->group(function () {
            Route::post('upload', 'lmsUploadFile')->name('lms.lmsUploadFile');
        });
    });
});
