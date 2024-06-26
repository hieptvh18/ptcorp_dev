<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Common\Http\Controllers\TagsController;
use Modules\Common\Http\Controllers\CategoriesController;
use Modules\Common\Http\Controllers\Admin\WardAdminController;
use Modules\Common\Http\Controllers\Admin\CountryAdminController;
use Modules\Common\Http\Controllers\Admin\DistrictAdminController;
use Modules\Common\Http\Controllers\Admin\ProvinceAdminController;
use Modules\Common\Http\Controllers\Admin\Setting\FlagSettingAdminController;

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


Route::controller(TagsController::class)->group(function () {
    Route::get('tags', 'index')->name('tags.index');

    Route::post('tags', 'store')->name('tags.store');

    Route::get('tags/{item}', 'show')->name('tags.show');

    Route::put('tags/{item}', 'update')->name('tags.update');

    Route::delete('tags/{item}', 'destroy')->name('tags.destroy');
});
Route::controller(CategoriesController::class)->group(function () {
    Route::get('categories', 'index')->name('categories.index');

    Route::post('categories', 'store')->name('categories.store');

    Route::get('categories/{item}', 'show')->name('categories.show');

    Route::put('categories/{item}', 'update')->name('categories.update');

    Route::delete('categories/{item}', 'destroy')->name('categories.destroy');
});

Route::group([
    'prefix' => 'v1/admin',
    'middleware' => 'auth:sanctum'
], function () {

    Route::controller(FlagSettingAdminController::class)->group(function () {

        Route::post('save-flag-setting', 'saveFlagSetting')->name('admin.saveFlagSetting');
        Route::get('flag-setting', 'getFlagSetting')->name('admin.getFlagSetting');
    });

    Route::controller(CountryAdminController::class)->group(function () {
        Route::get('countries', 'index')->name('countries.index');

        Route::post('countries', 'store')->name('countries.store');

        Route::get('countries/{item}', 'show')->name('countries.show');

        Route::put('countries/{item}', 'update')->name('countries.update');

        Route::delete('countries/{item}', 'destroy')->name('countries.destroy');
    });

    Route::controller(ProvinceAdminController::class)->group(function () {
        Route::get('provinces', 'index')->name('provinces.index');

        Route::post('provinces', 'store')->name('provinces.store');

        Route::get('provinces/{item}', 'show')->name('provinces.show');

        Route::put('provinces/{item}', 'update')->name('provinces.update');

        Route::delete('provinces/{item}', 'destroy')->name('provinces.destroy');
    });

    Route::controller(DistrictAdminController::class)->group(function () {
        Route::get('districts', 'index')->name('districts.index');

        Route::post('districts', 'store')->name('districts.store');

        Route::get('districts/{item}', 'show')->name('districts.show');

        Route::put('districts/{item}', 'update')->name('districts.update');

        Route::delete('districts/{item}', 'destroy')->name('districts.destroy');
    });

    Route::controller(WardAdminController::class)->group(function () {
        Route::get('wards', 'index')->name('wards.index');

        Route::post('wards', 'store')->name('wards.store');

        Route::get('wards/{item}', 'show')->name('wards.show');

        Route::put('wards/{item}', 'update')->name('wards.update');

        Route::delete('wards/{item}', 'destroy')->name('wards.destroy');
    });
});
