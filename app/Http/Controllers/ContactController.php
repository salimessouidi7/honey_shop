<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function create()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $contactMessage = ContactMessage::create([
            'user_id' => $request->user()?->id,
            ...$validated,
        ]);

        $staff = User::whereIn('role', ['admin', 'staff'])->get();
        Notification::send($staff, new NewContactMessage($contactMessage));

        return redirect()->route('contact')->with('success', "Your message has been sent! We'll get back to you soon.");
    }
}
