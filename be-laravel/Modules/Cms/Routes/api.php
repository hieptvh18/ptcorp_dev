<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\UploadController;

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
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::controller(UploadController::class)->group(function () {
            Route::post('upload', 'uploadFile')->name('cms.uploadFile');
        });

    });
});
