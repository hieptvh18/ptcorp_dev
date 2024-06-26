<?php

namespace Modules\Auth\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WorkspaceAddMemberNotification extends Notification
{
    use Queueable;

    protected $team;
    protected $base_url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($team, $base_url)
    {
        $this->team = $team;
        $this->base_url = $base_url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $data = $this->toArray($notifiable);
        return (new MailMessage)
            ->subject('Thông báo lời mời vào workspace')
            ->markdown('auth::notifications.addMemberToTeam', $data);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $url = ($this->base_url ?: config('app.frontend_url'));
        $data = [
            'team' => $this->team,
            'url' => $url
        ];
        return $data;
    }
}
