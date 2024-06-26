<?php

namespace Modules\Lms\Providers;

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
        $this->app->bind(\Modules\Lms\Repositories\ClassRoomRepository::class, \Modules\Lms\Repositories\ClassRoomRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\MemberRepository::class, \Modules\Lms\Repositories\MemberRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\SchoolLevelRepository::class, \Modules\Lms\Repositories\SchoolLevelRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\MajorRepository::class, \Modules\Lms\Repositories\MajorRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\SubjectRepository::class, \Modules\Lms\Repositories\SubjectRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\SkillRepository::class, \Modules\Lms\Repositories\SkillRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\TopicRepository::class, \Modules\Lms\Repositories\TopicRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\EventRepository::class, \Modules\Lms\Repositories\EventRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\EventLogRepository::class, \Modules\Lms\Repositories\EventLogRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\NotificationRepository::class, \Modules\Lms\Repositories\NotificationRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\LmsRoleRepository::class, \Modules\Lms\Repositories\LmsRoleRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\SchoolYearRepository::class, \Modules\Lms\Repositories\SchoolYearRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\NotificationConfigRepository::class, \Modules\Lms\Repositories\NotificationConfigRepositoryEloquent::class);
        $this->app->bind(\Modules\Lms\Repositories\ExamRoomRepository::class, \Modules\Lms\Repositories\ExamRoomRepositoryEloquent::class);
        //:end-bindings::end-bindings:
    }
}
