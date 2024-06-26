<?php

namespace Modules\Lms\Events;

use Illuminate\Queue\SerializesModels;

class EventAdminMemberServiceCreateMemberAfter
{
    use SerializesModels;

    public $member;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($member)
    {
        $this->member = $member;
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
