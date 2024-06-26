<?php

use Illuminate\Http\Request;
use Modules\Common\Http\Controllers\TagsController;
use Illuminate\Support\Facades\Route;
use Modules\Common\Http\Controllers\CategoriesController;

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
    'prefix' => 'common'

], function() {
    Route::controller(TagsController::class)->group(function() {
        Route::get('tags', 'index')->name('tags.index');

        Route::post('tags', 'store')->name('tags.store');

        Route::get('tags/{item}', 'show')->name('tags.show');

        Route::put('tags/{item}', 'update')->name('tags.update');

        Route::delete('tags/{item}', 'destroy')->name('tags.destroy');
    });
    Route::controller(CategoriesController::class)->group(function() {
        Route::get('categories', 'index')->name('categories.index');

        Route::post('categories', 'store')->name('categories.store');

        Route::get('categories/{item}', 'show')->name('categories.show');

        Route::put('categories/{item}', 'update')->name('categories.update');

        Route::delete('categories/{item}', 'destroy')->name('categories.destroy');
   });
});
