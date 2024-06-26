<?php

namespace Modules\Auth\Listeners;

use Modules\Lms\Models\Member;
use Modules\Lms\Models\LmsRole;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Events\EventWorkspaceInfoServiceAddMembersAfter;

class ListenerWorkspaceInfoServiceAddMembersAfter
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
     * @param EventWorkspaceInfoServiceAddMembersAfter $event
     * @return void
     */
    public function handle(EventWorkspaceInfoServiceAddMembersAfter $event)
    {
        $workspace = $event->workspace;
        $user = $event->user;
        $email = $user->email ?? null;
        $user_info = $user->info;
        Http::post(config('auth.service_url.lms')."/lms/api/public/v1/add-member", [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'wp_alias' => $workspace->alias,
            'user_id' => $user->id,
            'firstname' => $user->info->first_name,
            'lastname' => $user->info->last_name,
            'birth_day' => $user->info->birthday,
            'mobile' => $user->mobile ?? '0989999999',
            'email' => $user->email,
            'type' => 'STUDENT',
            'avatar_url' => $user->info->avatar_url
        ]);

    }
}
