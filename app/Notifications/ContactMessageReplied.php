<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ContactMessageReplied extends Notification
{
    use Queueable;

    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => '💬',
            'title'   => 'Honey Shop replied to your message',
            'message' => Str::limit($this->contactMessage->admin_reply, 60),
            'url'     => route('messages.index'),
        ];
    }
}
