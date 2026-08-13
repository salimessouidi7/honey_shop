@extends(in_array(auth()->user()->role, ['admin', 'staff']) ? 'admin.layout' : 'layouts.app')

@section('title', __('Notifications'))

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">{{ __('Notifications') }}</h1>

        @if ($notifications->total() > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">{{ __('Mark all as read') }}</button>
            </form>
        @endif
    </div>

    <div class="card">
        @forelse ($notifications as $notification)
            <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="border-bottom">
                @csrf
                <button type="submit" class="dropdown-item {{ $notification->read_at ? '' : 'fw-bold' }} w-100 text-start border-0 bg-transparent p-3">
                    <span>{{ $notification->data['icon'] ?? '🔔' }}</span>
                    {{ $notification->data['title'] ?? __('Notification') }}
                    <div class="text-muted fw-normal small">{{ $notification->data['message'] ?? '' }}</div>
                    <div class="text-muted small mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                </button>
            </form>
        @empty
            <p class="text-muted p-3 mb-0">{{ __('No notifications yet.') }}</p>
        @endforelse
    </div>

    <div class="mt-3">{{ $notifications->links() }}</div>

@endsection
