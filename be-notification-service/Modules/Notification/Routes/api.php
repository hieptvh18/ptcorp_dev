<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Notification\Models\DeviceToken;
use Modules\Notification\Http\Controllers\NotificationController;
use Modules\Notification\Http\Controllers\Admin\CampainAdminController;
use Modules\Notification\Http\Controllers\Admin\EmailLogAdminController;
use Modules\Notification\Http\Controllers\Admin\DeviceTokenAdminController;
use Modules\Notification\Http\Controllers\Admin\EmailTemplateAdminController;

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

Route::group(
    ['prefix' => 'v1/public'],
    function () {
        Route::controller(NotificationController::class)->group(function () {
            Route::post('save-token', 'saveToken')->name('notification.public.saveToken');
            Route::post('push-notification', 'pushNotification')->name('notification.public.send');
        });
    }

);

Route::group([
    'prefix' => 'v1/admin',
    'middleware' => 'auth:sanctum'
], function () {
    Route::controller(EmailTemplateAdminController::class)->group(function () {
        Route::get('email-templates', 'index')->name('notification.email-templates.index');
        Route::get('email-templates/{id}', 'show')->name('notification.email-templates.show');
        Route::post('email-templates', 'store')->name('notification.email-templates.store');
        Route::put('email-templates/{id}', 'update')->name('notification.email-templates.update');
        Route::delete('email-templates/{id}', 'destroy')->name('notification.email-templates.destroy');
    });

    Route::controller(EmailLogAdminController::class)->group(function () {
        Route::get('email-logs', 'index')->name('notification.email-logs.index');
        Route::get('email-logs/{id}', 'show')->name('notification.email-logs.show');
    });

    Route::controller(CampainAdminController::class)->group(function () {
        Route::get('campains', 'index')->name('notification.campaints.index');
        Route::get('campains/{id}', 'show')->name('notification.campaints.show');
        Route::post('campains', 'store')->name('notification.campaints.store');
        Route::put('campains/{id}', 'update')->name('notification.campaints.update');
        Route::delete('campaints/{id}', 'destroy')->name('notification.campaints.destroy');
    });

    Route::controller(DeviceTokenAdminController::class)->group(function () {
        Route::get('device-tokens', 'index')->name('notification.deviceToken.index');
    });
});
