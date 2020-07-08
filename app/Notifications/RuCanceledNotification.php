<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class RuCanceledNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return [ExpoChannel::class];
    }

    public function toExpoPush($notifiable)
    {
        return ExpoMessage::create()
            // ->setTtl(5000)
            ->badge(1)
            ->title("Бронирование отменено")
            ->enableSound()
            ->body("Ваше  : " . $notifiable->refCode . "  бронирование было отменено")
            ->setChannelId("PCHELKA-CLEANING")
            ->setJsonData(["status" => $notifiable->bookStatus]);

    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
