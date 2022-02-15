<?php

namespace Bluex\Fcm\Serices;

use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toFirebase($notifiable);
    }
}
