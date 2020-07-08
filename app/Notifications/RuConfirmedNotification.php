<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class RuConfirmedNotification extends Notification
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
            ->title("Бронирование подтверждено")
            ->enableSound()
            ->body("Ваш заказ подтвержден, до скорой встречи :) ")
            ->setChannelId("PCHELKA-CLEANING")
            ->setJsonData(["status"=>$notifiable->bookStatus]);
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
