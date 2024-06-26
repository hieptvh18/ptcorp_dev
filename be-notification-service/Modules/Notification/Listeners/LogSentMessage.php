<?php

namespace Modules\Notification\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Models\EmailLog;

class LogSentMessage implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'email';
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
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        EmailLog::where([
            'status' => 'PENDING',
            'subject' => $event->message->getSubject(),
            'recipient' => $event->message->getTo()[0]->getAddress(),
            'sender' => $event->message->getFrom()[0]->getAddress(),

        ])->update(['status' => 'SENT']);
    }
}
