<?php

namespace App\Notifications;

use App\Enums\BookingStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class RuRescheduledNotification extends Notification
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
            ->title("Бронирование перенесено")
            ->enableSound()
            ->body("аш " . $notifiable->refCode . " заказ был перенесен, скоро увидимся :) ")
            ->setChannelId("PCHELKA-CLEANING")
            ->setJsonData(["refCode" => $notifiable->refCode, "status" => $notifiable->bookStatus]);

    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
