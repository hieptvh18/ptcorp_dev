<?php

namespace Modules\Auth\Listeners;

use Modules\Quiz\Models\ExamChanel;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Auth\Events\UserRegisterAfter;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisterAfterListener
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
     * @param UserRegisterAfter $event
     * @return void
     */
    public function handle(UserRegisterAfter $event)
    {
        $user = $event->user;
        ExamChanel::create(
            [
                'name' => $user->info->first_name . ' ' . $user->info->last_name,
                'status' => 'PUBLISH',
                'created_by' => $user->id,
                'user_id' => $user->id
            ]
        );
    }
}
