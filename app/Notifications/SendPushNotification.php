<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Notification;
use App\Models\Notification as NotificationModel;

use Kutia\Larafirebase\Messages\FirebaseMessage;

class SendPushNotification extends Notification
{
    use Queueable;
    protected NotificationModel $notification;
    protected $fcmTokens;
    public function __construct($notification,$fcmTokens)
    {
        $this->notification=$notification;
        $this->fcmTokens=$fcmTokens;
    }


    public function via($notifiable)
    {
        return ['firebase'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toFirebase($notifiable)
    {
        return (new FirebaseMessage)
            ->withTitle('hello')
            ->withBody($this->notification->content)
            ->withPriority('high')->asMessage($this->fcmTokens);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
