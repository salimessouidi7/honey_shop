<div class="dropdown">
    <button
        class="btn btn-link position-relative p-0 border-0 honey-notif-btn"
        type="button"
        id="notifDropdown"
        data-bs-toggle="dropdown"
        aria-expanded="false"
        style="font-size: 1.3rem; text-decoration: none;">

        🔔

        @php $unreadCount = auth()->user()->unreadNotifications->count(); @endphp
        @if ($unreadCount > 0)
            <span class="honey-cart-badge">{{ $unreadCount }}</span>
        @endif
    </button>

    <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 320px; max-height: 420px; overflow-y: auto;" aria-labelledby="notifDropdown">
        @forelse (auth()->user()->notifications()->latest()->take(8)->get() as $notification)
            <li>
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item {{ $notification->read_at ? '' : 'fw-bold' }} small py-2 text-wrap w-100 text-start border-0 bg-transparent">
                        <span>{{ $notification->data['icon'] ?? '🔔' }}</span>
                        {{ $notification->data['title'] ?? __('Notification') }}
                        <div class="text-muted fw-normal" style="font-size: 12px;">{{ $notification->data['message'] ?? '' }}</div>
                    </button>
                </form>
            </li>
        @empty
            <li><span class="dropdown-item-text text-muted small">{{ __('No notifications yet.') }}</span></li>
        @endforelse

        @if (auth()->user()->notifications()->count() > 0)
            <li><hr class="dropdown-divider"></li>
            <li class="d-flex justify-content-between align-items-center px-2">
                <a href="{{ route('notifications.index') }}" class="small">{{ __('View all') }}</a>
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link p-0 small">{{ __('Mark all read') }}</button>
                </form>
            </li>
        @endif
    </ul>
</div>
