<?php

namespace Modules\Lms\Listeners;

use Modules\Lms\Events\EventAdminMemberServiceCreateMemberAfter;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Lms\Services\AuthService;

class ListenerCreateAccount
{
    protected $authService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle the event.
     *
     * @param EventAdminMemberServiceCreateMemberAfter $event
     * @return void
     */
    public function handle(EventAdminMemberServiceCreateMemberAfter $event)
    {
        $member = $event->member;
        $data = $this->authService->createAccount($member);
        $this->authService->attachTeamWork($data->user->id);
        return $data;
    }
}
