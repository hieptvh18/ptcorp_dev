<?php

namespace Modules\Notification\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notification\Models\EmailLog;
use Modules\Notification\Models\EmailTemplate;

class LogSendingMessage implements ShouldQueue
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
     * @param  MessageSending  $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        $arr_cc = ($event->message->getCc());
        $arr_bcc = ($event->message->getBcc());
        $maill_cc = [];
        $mail_bcc = [];
        foreach ($arr_cc as $cc) {
            array_push($maill_cc, $cc->getAddress());
        }

        foreach ($arr_bcc as $bcc) {
            array_push($mail_bcc, $bcc->getAddress());
        }

        EmailLog::create([
            'status' => 'PENDING',
            'subject' => $event->message->getSubject(),
            'recipient' => $event->message->getTo()[0]->getAddress(),
            'sender' => $event->message->getFrom()[0]->getAddress(),
            'cc' => implode(',', $maill_cc),
            'bcc' => implode(',', $mail_bcc),
            'variables' => $event->message->getTextBody(),
            // 'tempalate_id' => $event->data['template']['id'] ?? null,
            // 'template_forzen' => [
            //     'name' => $event->data['template']['name'],
            //     'render' => $event->data['template']['content'],
            //     'hash' => $template->getHash()
            // ],
            'error' => '',

        ]);
    }
}
