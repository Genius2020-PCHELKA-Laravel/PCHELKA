<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class
ExpoNotification extends Notification
{
   use Queueable;

    public function __construct(){
    }

    public function via($notifiable)
    {
        return [ExpoChannel::class];
    }

    public function toExpoPush($notifiable){
        return ExpoMessage::create()
            // ->setTtl(5000)
            ->badge(1)
            ->title("Hello World!")
            ->enableSound()
            ->body("Hello World!")
          ->setChannelId("PCHELKA-CLEANING");
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
