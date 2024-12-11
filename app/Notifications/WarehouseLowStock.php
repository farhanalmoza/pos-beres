<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class WarehouseLowStock extends Notification
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

    public function toTelegram($notifiable)
    {
        return TelegramMessage::create()
            ->to(env('TELEGRAM_GROUP_STAFF_ID'))
            ->content("
            ⚠️ PERINGATAN STOK MENIPIS DI GUDANG ⚠️\n\n".
                "Produk: {$this->product->name}\n".
                "Stok Tersisa: {$this->product->quantity}\n".
                "Batas Minimum: {$this->product->low_stock}\n\n".
                "Mohon segera lakukan restock.
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
