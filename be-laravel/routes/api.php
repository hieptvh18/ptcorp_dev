<?php

use App\Http\Controllers\TestMailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'test-mail'
], function () {
    Route::controller(TestMailController::class)->group(function () {

        Route::get('create-order', 'testCreateOrder');
        Route::get('update-order', 'testUpdateOrder');
        // Route::get('event', 'testUpdateOrder');
    });
});
