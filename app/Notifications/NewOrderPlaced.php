<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderPlaced extends Notification
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => '📦',
            'title'   => 'New order placed',
            'message' => "Order #{$this->order->id} from {$this->order->guest_name} - \${$this->formattedTotal()}",
            'url'     => route('admin.orders.show', $this->order),
        ];
    }

    private function formattedTotal(): string
    {
        return number_format($this->order->total, 2);
    }
}
