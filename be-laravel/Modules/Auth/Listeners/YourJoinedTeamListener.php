<?php

namespace Modules\Auth\Listeners;

use Modules\Auth\Models\Role;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Events\UserRegisterAfter;
use Mpociot\Teamwork\Events\UserJoinedTeam;
use Illuminate\Support\Facades\Notification;
use Modules\Auth\Notifications\WorkspaceAddMemberNotification;

class YourJoinedTeamListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserJoinedTeam $event
     * @return void
     */
    public function handle(UserJoinedTeam $event)
    {
        $base_url = request('base_url');
        $user = $event->getUser();
        $team = Teamwork::find($event->getTeamId());

        Notification::send($user, new WorkspaceAddMemberNotification($team, $base_url));
    }
}
