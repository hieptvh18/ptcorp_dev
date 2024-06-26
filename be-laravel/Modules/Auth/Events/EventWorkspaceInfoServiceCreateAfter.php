<?php

namespace Modules\Auth\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Auth\Models\WorkspaceInfo;

class EventWorkspaceInfoServiceCreateAfter
{
    use SerializesModels;

    public $workspaceInfo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WorkspaceInfo $workspaceInfo)
    {
        $this->workspaceInfo = $workspaceInfo;
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
