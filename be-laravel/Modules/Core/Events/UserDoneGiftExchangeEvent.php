<?php

namespace Modules\Core\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class UserDoneGiftExchangeEvent
{
    use SerializesModels;

    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
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
