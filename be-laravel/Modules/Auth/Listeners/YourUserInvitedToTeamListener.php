<?php

namespace Modules\Auth\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mpociot\Teamwork\Events\UserInvitedToTeam;
use Illuminate\Support\Facades\Notification;
use Modules\Auth\Notifications\InvitedTeamNotification;

class YourUserInvitedToTeamListener
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
     * @param  UserInvitedToTeam  $event
     * @return void
     */
    public function handle(UserInvitedToTeam $event)
    {
        $invite = $event->getInvite();
        $email = $invite->email;
        $team = $invite->team;
        Notification::route('mail', $email)->notify(new InvitedTeamNotification($team));
    }
}
