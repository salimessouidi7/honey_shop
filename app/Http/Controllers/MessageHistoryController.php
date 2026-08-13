<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class MessageHistoryController extends Controller
{
    public function index(Request $request)
    {
        $messages = ContactMessage::where('user_id', $request->user()->id)->latest()->get();
        return view('messages.index', compact('messages'));
    }
}
