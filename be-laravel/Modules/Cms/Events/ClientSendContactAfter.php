<?php

namespace Modules\Cms\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Cms\Models\CmsStudentContact;

class ClientSendContactAfter
{
    use SerializesModels;

    public $contact;
    public $workspaceAlias;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CmsStudentContact $contact,$workspaceAlias)
    {
        $this->contact = $contact;
        $this->workspaceAlias = $workspaceAlias;
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
