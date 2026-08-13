<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Notifications\ContactMessageReplied;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage)
    {
        return view('admin.messages.show', compact('contactMessage'));
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $validated = $request->validate([
            'admin_reply' => ['required', 'string', 'max:2000'],
        ]);

        $contactMessage->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_at'  => now(),
            'status'      => 'replied',
        ]);

        // Only fires if the message came from a logged-in customer - guests
        // have no account to notify, they'd need to check back manually.
        if ($contactMessage->user_id) {
            $contactMessage->user->notify(new ContactMessageReplied($contactMessage));
        }

        return back()->with('success', 'Reply sent.');
    }
}
