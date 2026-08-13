@extends('layouts.app')

@section('title', 'My Messages')

@section('content')

    <h1 class="mb-3">My Messages</h1>

    @if ($messages->isEmpty())
        <div class="alert alert-info">You haven't sent any messages yet.</div>
    @else
        @foreach ($messages as $msg)
            <div class="card mb-3 p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="mb-1">{{ $msg->subject }}</h5>
                    <span class="status {{ $msg->status === 'replied' ? 'completed' : 'pending' }}">{{ ucfirst($msg->status) }}</span>
                </div>
                <p class="text-muted small mb-2">{{ $msg->created_at->format('M d, Y H:i') }}</p>
                <p class="mb-0">{{ $msg->message }}</p>

                @if ($msg->admin_reply)
                    <div class="border-top pt-3 mt-3">
                        <strong>🍯 Honey Shop replied:</strong>
                        <p class="mb-1">{{ $msg->admin_reply }}</p>
                        <small class="text-muted">{{ $msg->replied_at->format('M d, Y H:i') }}</small>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    <a href="{{ route('contact') }}" class="btn btn-primary">Send New Message</a>

@endsection
