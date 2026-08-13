@extends('admin.layout')

@section('title', __('Message from') . ' ' . $contactMessage->name)

@section('content')

    <div class="card mb-4 p-4">
        <h2>{{ $contactMessage->subject }}</h2>
        <p class="mb-1"><strong>{{ __('From') }}:</strong> {{ $contactMessage->name }} ({{ $contactMessage->email }})</p>
        <p class="mb-1"><strong>{{ __('Date') }}:</strong> {{ $contactMessage->created_at->format('M d, Y H:i') }}</p>
        <hr>
        <p class="mb-0">{{ $contactMessage->message }}</p>
    </div>

    @if ($contactMessage->admin_reply)
        <div class="card mb-4 p-4">
            <h5>{{ __('Your Reply') }}</h5>
            <p class="mb-1">{{ $contactMessage->admin_reply }}</p>
            <small class="text-muted">{{ __('Sent') }} {{ $contactMessage->replied_at->format('M d, Y H:i') }}</small>
        </div>
    @endif

    <div class="card p-4">
        <h5>{{ $contactMessage->admin_reply ? __('Send Another Reply') : __('Reply') }}</h5>

        <form method="POST" action="{{ route('admin.messages.reply', $contactMessage) }}">
            @csrf
            <textarea name="admin_reply" rows="4" class="form-control @error('admin_reply') is-invalid @enderror" required>{{ old('admin_reply') }}</textarea>

            @error('admin_reply')
                <div class="text-danger small mt-1">{{ $errors->first('admin_reply') }}</div>
            @enderror

            <button type="submit" class="btn btn-primary mt-3">{{ __('Send Reply') }}</button>
        </form>
    </div>

@endsection
