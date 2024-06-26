<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Cms\Http\Controllers\Admin\AdminFaqController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsBlogController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsBannerController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsCourseController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsBlogTagController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsContactController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsSettingController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsCategoryController;
use Modules\Cms\Http\Controllers\Admin\AdminCmsFeedbackController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseLearnController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseLevelController;
use Modules\Cms\Http\Controllers\Admin\AdminFaqCategoryController;
use Modules\Cms\Http\Controllers\Admin\AdminReviewCourseController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseLessionController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseSectionController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseLanguageController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseScheduleController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseInstructorController;
use Modules\Cms\Http\Controllers\Admin\AdminCourseRequirementController;
use Modules\Cms\Http\Controllers\Admin\CmsSettingController;

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
    'name' => 'admin.'
], function () {
    Route::group([
        'middleware' => 'auth:sanctum'
    ], function () {
        Route::resource('cms-banners', AdminCmsBannerController::class);
        Route::resource('cms-categories', AdminCmsCategoryController::class);
        Route::resource('cms-feedbacks', AdminCmsFeedbackController::class);
        Route::resource('cms-student-contacts', AdminCmsContactController::class)->except(['update']);
        Route::resource('cms-faq-categories', AdminFaqCategoryController::class);
        Route::resource('cms-faqs', AdminFaqController::class);
        Route::resource('cms-course-instructor', AdminCourseInstructorController::class);
        Route::resource('cms-courses', AdminCmsCourseController::class);
        Route::controller(AdminCourseSectionController::class)->group(function (){
            Route::get('cms-course/sections/{section_id}','show')->name('cms.course.section.get_detail');
            Route::post('cms-course/sections','store')->name('cms.course.section.store');
            Route::put('cms-course/sections/{section_id}','update')->name('cms.course.section.update');
            Route::delete('cms-course/sections/{section_id}','destroy')->name('cms.course.section.delete');
            Route::get('cms-courses/{course_id}/sections','findSectionsByCourseId')->name('cms.course.section.get_by_course_id');
        });
        Route::controller(AdminCmsBlogController::class)->group(function () {
            Route::get('blogs', 'index')->name('admin.blogs.index');
            Route::get('blogs/{id}', 'show')->name('admin.blogs.show');
            Route::post('blogs', 'store')->name('admin.blogs.store');
            Route::put('blogs/{id}', 'update')->name('admin.blogs.update');
            Route::delete('blogs/{id}', 'destroy')->name('admin.blogs.destroy');
        });

        Route::controller(AdminCmsBlogTagController::class)->group(function () {
            Route::get('blog-tags', 'index')->name('admin.blog-tags.index');
            Route::get('blog-tags/{id}', 'show')->name('admin.blog-tags.show');
            Route::post('blog-tags', 'store')->name('admin.blog-tags.store');
            Route::put('blog-tags/{id}', 'update')->name('admin.blog-tags.update');
            Route::delete('blog-tags/{id}', 'destroy')->name('admin.blog-tags.destroy');
        });

        Route::controller(AdminCourseLessionController::class)->group(function (){
            Route::get('cms-course/lessons/{lesson_id}','show')->name('cms.course.lesson.get_detail');
            Route::post('cms-course/lessons','store')->name('cms.course.lesson.store');
            Route::put('cms-course/lessons/{lesson_id}','update')->name('cms.course.lesson.update');
            Route::delete('cms-course/lessons/{lesson_id}','destroy')->name('cms.course.lesson.delete');
            Route::get('cms-courses/{course_id}/sections/{section_id}/lessions','findLessonsByCourseId')->name('cms.course.lesson.get_by_section_id');
        });
        Route::controller(AdminCourseLearnController::class)->group(function(){
            Route::get('cms-course/{course_id}/learns','findLearnsByCourseId')->name('cms.course.learn.find_by_course_id');
            Route::post('cms-course/{course_id}/learns','save')->name('cms.course.learn.save');
            Route::delete('cms-course/learns/{id}','destroy')->name('cms.course.learn.destroy');
        });
        Route::controller(AdminCourseRequirementController::class)->group(function(){
            Route::get('cms-course/{course_id}/requirements','findRequirementsByCourseId')->name('cms.course.requirement.find_by_course_id');
            Route::post('cms-course/{course_id}/requirements','save')->name('cms.course.requirement.save');
            Route::delete('cms-course/requirements/{id}','destroy')->name('cms.course.requirement.destroy');
        });

        Route::resource('cms-course/levels', AdminCourseLevelController::class);
        Route::controller(AdminCourseLanguageController::class)->group(function (){
            Route::get('cms-course/languages','index')->name('cms.course.languages.all');
        });
        Route::controller(AdminReviewCourseController::class)->group(function (){
           Route::get('cms-course/review','index')->name('cms.course.review.index');
           Route::get('cms-course/review/{id}','show')->name('cms.course.review.show');
           Route::post('cms-course/review','store')->name('cms.course.review.store');
           Route::put('cms-course/review/{id}','update')->name('cms.course.review.update');
           Route::delete('cms-course/review/{id}','destroy')->name('cms.course.review.delete');
        });

        Route::controller(CmsSettingController::class)->group(function () {
            Route::get('settings/{website_id}/{group}', 'getSetting')->name('admin.setting.getSetting');
            Route::post('setting', 'saveSetting')->name('admin.setting.saveSetting');
        });

    });
});
