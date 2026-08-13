<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class LowStockAlert extends Notification
{
    use Queueable;

    public function __construct(public Product $product)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => '⚠️',
            'title'   => 'Low stock alert',
            'message' => "{$this->product->name} is down to {$this->product->stock} in stock",
            'url'     => route('admin.products.edit', $this->product),
        ];
    }
}
