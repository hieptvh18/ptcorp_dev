<?php

namespace Modules\Cms\Providers;

use Modules\Auth\Events\UserRegisterAfter;
use Modules\Auth\Listeners\UserRegisterAfterListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Cms\Events\ClientSendContactAfter;
use Modules\Cms\Listeners\ListenserClientSendContactAfter;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ClientSendContactAfter::class => [
            ListenserClientSendContactAfter::class,
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
