<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class StoreLowStock extends Notification
{
    use Queueable;

    protected $product;
    protected $store;

    /**
     * Create a new notification instance.
     */
    public function __construct($product, $store)
    {
        $this->product = $product;
        $this->store = $store;
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
        return TelegramMessage::create()
            ->to(env('TELEGRAM_GROUP_STAFF_ID'))
            ->content("
            ⚠️ PERINGATAN STOK MENIPIS DI TOKO {$this->store->name} ⚠️\n\n".
                "Produk: {$this->product->product->name}\n".
                "Stok Tersisa: {$this->product->quantity}\n".
                "Batas Minimum: {$this->product->product->low_stock}\n\n".
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
