<?php

namespace Modules\Cms\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function boot()
    {
        $this->app->bind(\Modules\Cms\Repositories\CmsBannerRepository::class, \Modules\Cms\Repositories\CmsBannerRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsCategoryRepository::class, \Modules\Cms\Repositories\CmsCategoryRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsFeedbackRepository::class, \Modules\Cms\Repositories\CmsFeedbackRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsStudentContactRepository::class, \Modules\Cms\Repositories\CmsStudentContactRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseInstructorRepository::class, \Modules\Cms\Repositories\CourseInstructorRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseRepository::class, \Modules\Cms\Repositories\CourseRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseSectionRepository::class, \Modules\Cms\Repositories\CourseSectionRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseLessionRepository::class, \Modules\Cms\Repositories\CourseLessionRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsFaqCategoryRepository::class, \Modules\Cms\Repositories\CmsFaqCategoryRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsFaqRepository::class, \Modules\Cms\Repositories\CmsFaqRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseLearnRepository::class, \Modules\Cms\Repositories\CourseLearnRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseRequirementRepository::class, \Modules\Cms\Repositories\CourseRequirementRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseScheduleRepository::class, \Modules\Cms\Repositories\CourseScheduleRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsBlogRepository::class, \Modules\Cms\Repositories\CmsBlogRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsBlogTagRepository::class, \Modules\Cms\Repositories\CmsBlogTagRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseLevelRepository::class, \Modules\Cms\Repositories\CourseLevelRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CourseLanguageRepository::class, \Modules\Cms\Repositories\CourseLanguageRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsReviewRepository::class, \Modules\Cms\Repositories\CmsReviewRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\SettingRepository::class, \Modules\Cms\Repositories\SettingRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\CmsSettingRepository::class, \Modules\Cms\Repositories\CmsSettingRepositoryEloquent::class);
        $this->app->bind(\Modules\Cms\Repositories\TestRepository::class, \Modules\Cms\Repositories\TestRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
