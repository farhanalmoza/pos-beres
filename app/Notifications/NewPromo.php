<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class NewPromo extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Create a new notification instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram(object $notifiable)
    {
        $promoPrice = $this->product->price - $this->product->discount;
        return TelegramMessage::create()
            ->to(env('TELEGRAM_GROUP_MEMBER_ID'))
            ->content("
            UPDATE NEW PROMO\n\n".
                "{$this->product->name}\n".
                "Harga normal: {$this->product->price}\n".
                "Harga promo: {$promoPrice}
            ");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
