<?php

namespace Modules\Auth\Providers;

use Modules\Auth\Events\UserRegisterAfter;
use Mpociot\Teamwork\Events\UserJoinedTeam;
use Modules\Auth\Listeners\YourJoinedTeamListener;
use Modules\Auth\Listeners\UserRegisterAfterListener;
use Modules\Auth\Listeners\YourUserInvitedToTeamListener;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;
use Modules\Auth\Listeners\ListenerWorkspaceInfoServiceCreateAfter;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Auth\Events\EventWorkspaceInfoServiceAddMembersAfter;
use Modules\Auth\Listeners\ListenerWorkspaceInfoServiceAddMembersAfter;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegisterAfter::class => [
            UserRegisterAfterListener::class,
        ],

        EventWorkspaceInfoServiceCreateAfter::class => [
            ListenerWorkspaceInfoServiceCreateAfter::class
        ],

        UserJoinedTeam::class => [
            YourJoinedTeamListener::class
        ],

        EventWorkspaceInfoServiceAddMembersAfter::class => [
            ListenerWorkspaceInfoServiceAddMembersAfter::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
