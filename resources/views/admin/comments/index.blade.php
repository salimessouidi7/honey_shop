@extends('admin.layout')

@section('title', __('Comments & Feedback'))

@section('content')

    @unless (\App\Models\Feature::enabled('comments'))
        <div class="alert alert-secondary">
            {{ __('The Comments & Feedback feature is currently disabled. Customers can\'t leave new feedback, but you can still review and remove existing comments below.') }}
            <a href="{{ route('admin.settings.index') }}">{{ __('Go to Settings') }}</a>
        </div>
    @endunless

    <div class="card">
        <table class="table">
            <thead>
                <tr><th>{{ __('Product') }}</th><th>{{ __('Customer') }}</th><th>{{ __('Rating') }}</th><th>{{ __('Comment') }}</th><th>{{ __('Date') }}</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($comments as $comment)
                    <tr>
                        <td>{{ $comment->product->name ?? __('Deleted product') }}</td>
                        <td>{{ $comment->user->name ?? __('Deleted user') }}</td>
                        <td>
                            @if ($comment->rating)
                                <span class="text-warning">{{ str_repeat('★', $comment->rating) }}{{ str_repeat('☆', 5 - $comment->rating) }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($comment->body, 60) }}</td>
                        <td>{{ $comment->created_at->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                                  onsubmit="return confirm('{{ __('Delete this comment?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">{{ __('No comments yet.') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">{{ $comments->links() }}</div>

@endsection
