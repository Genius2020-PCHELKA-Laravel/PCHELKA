<?php

namespace App\Notifications;

use App\Enums\BookingStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class RescheduledNotification extends Notification
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
            ->title("Booking Rescheduled")
            ->enableSound()
            ->body("Your booking : " . $notifiable->refCode . "  has been rescheduled , see you soon :) ")
            ->setJsonData(["refCode" => $notifiable->refCode, "status" => BookingStatusEnum::getKey(3)])
            ->setChannelId("PCHELKA-CLEANING");
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
