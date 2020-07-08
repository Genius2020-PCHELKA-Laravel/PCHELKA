<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\ExpoPushNotifications\ExpoChannel;
use NotificationChannels\ExpoPushNotifications\ExpoMessage;

class CompletedNotification extends Notification
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
            ->title("Booking Completed")
            ->enableSound()
            ->body("Your booking : " . $notifiable->refCode . "  has been completed please rate the provider")
            ->setChannelId("PCHELKA-CLEANING")
            ->setJsonData(["image" => $notifiable->image,
                "refCode" => $notifiable->refCode,
                "bookId" => $notifiable->bookId,
                "providerId" => $notifiable->providerId,
                "evaluation" => $notifiable->evaluation,
                "status" => $notifiable->bookStatus,
                "providerName" => $notifiable->providerName
            ]);
    }

    public function toArray($notifiable)
    {
        return [
        ];
    }
}
