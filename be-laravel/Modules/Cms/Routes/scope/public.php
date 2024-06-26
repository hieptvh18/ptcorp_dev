<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\CmsBannerController;
use Modules\Cms\Http\Controllers\Public\CmsBlogController;
use Modules\Cms\Http\Controllers\Public\CmsBlogTagController;
use Modules\Cms\Http\Controllers\Public\CmsStudentContactController;
use Modules\Cms\Http\Controllers\Public\CmsFeedbackController;
use Modules\Cms\Http\Controllers\Public\CmsCourseController;
use Modules\Cms\Http\Controllers\Public\CmsCategoryController;
use Modules\Cms\Http\Controllers\Public\CmsReviewController;
use Modules\Cms\Http\Controllers\Public\CmsFaqController;
use Modules\Cms\Http\Controllers\Public\CmsSettingController;

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
    Route::controller(CmsBannerController::class)->group(function () {
        Route::get('banners-publish', 'getListBannerPublish')->name('lms.cms-banner.banner-publish');
    });
    Route::controller(CmsStudentContactController::class)->group(function () {
        Route::post('/student-contacts', 'store');
    });
    Route::controller(CmsFeedbackController::class)->group(function () {
        Route::get('/student-feedbacks', 'index');
    });
    Route::controller(CmsCourseController::class)->group(function () {
        Route::get('/courses', 'index');
        Route::get('/courses/meta/{alias}', 'getMetaCourse');
        Route::get('/courses/{id}', 'show');
        Route::get('/course-filterable', 'getFilterable');
        Route::get('/course/{course_id}/recommends', 'getRecommendCourses');
    });
    Route::controller(CmsCategoryController::class)->group(function () {
        Route::get('/course/categories', 'index');
    });

    Route::controller(CmsReviewController::class)->group(function () {
        Route::get('/course/{course_id}/reviews', 'index');
    });

    Route::controller(CmsBlogController::class)->group(function () {
        Route::get('blogs', 'getListBlog')->name('cms.public.blog.getListBlog');
        Route::get('blogs/{alias}', 'showBlogByAlias')->name('cms.public.blog.showBlogByAlias');
        Route::get('blogs/{blog_id}/relate', 'relatedBlog')->name('cms.public.blog.relatedBlog');
    });
    Route::controller(CmsFaqController::class)->group(function () {
        Route::get('/course/faqs', 'index');
    });

    Route::controller(CmsBlogTagController::class)->group(function () {
        Route::get('blog-tags', 'getListTagAssignBlog')->name('cms.public.blog-tag.getListTagAssignBlog');
    });
    Route::controller(CmsSettingController::class)->group(function () {
        Route::get('settings/{group}', 'getSettingGroup')->name('cms.public.setting.getSettingGroup');
    });
});
