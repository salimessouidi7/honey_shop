<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewContactMessage extends Notification
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
            'icon'    => '✉️',
            'title'   => 'New message from ' . $this->contactMessage->name,
            'message' => Str::limit($this->contactMessage->message, 60),
            'url'     => route('admin.messages.show', $this->contactMessage),
        ];
    }
}
