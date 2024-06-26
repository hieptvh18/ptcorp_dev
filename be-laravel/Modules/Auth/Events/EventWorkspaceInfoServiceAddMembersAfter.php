<?php

namespace Modules\Auth\Events;

use Illuminate\Queue\SerializesModels;

class EventWorkspaceInfoServiceAddMembersAfter
{
    use SerializesModels;

    public $workspace;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($workspace, $user)
    {
        $this->workspace = $workspace;
        $this->user = $user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
