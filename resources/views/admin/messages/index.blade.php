@extends('admin.layout')

@section('title', __('Messages'))

@section('content')

    <div class="card">
        <table class="table">
            <thead>
                <tr><th>{{ __('From') }}</th><th>{{ __('Subject') }}</th><th>{{ __('Status') }}</th><th>{{ __('Date') }}</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($messages as $msg)
                    <tr>
                        <td>{{ $msg->name }}<br><small class="text-muted">{{ $msg->email }}</small></td>
                        <td>{{ $msg->subject }}</td>
                        <td><span class="status {{ $msg->status === 'replied' ? 'completed' : 'pending' }}">{{ $msg->status === 'replied' ? __('Replied') : __('Open') }}</span></td>
                        <td>{{ $msg->created_at->format('M d, Y') }}</td>
                        <td><a href="{{ route('admin.messages.show', $msg) }}" class="btn btn-outline-primary btn-sm">{{ __('View') }}</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5">{{ __('No messages yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $messages->links() }}</div>

@endsection
