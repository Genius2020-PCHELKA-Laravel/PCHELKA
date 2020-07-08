<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class ConfirmedNotification extends Notification
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

       return  ExpoMessage::create()
            // ->setTtl(5000)
            ->badge(1)
            ->title("Booking Confirmed")
            ->enableSound()
            ->body("Your booking has been confirmed , see you soon :) ")
            ->setChannelId("PCHELKA-CLEANING")
            ->setJsonData(["status"=>$notifiable->bookStatus]);
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
