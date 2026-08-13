@extends('layouts.app')

@section('title', __('Your Cart'))

@section('content')

    <h1>{{ __('Your Cart') }}</h1>

    @if (empty($items))
        <div class="alert alert-info">{{ __('Your cart is empty.') }}</div>
        <a href="{{ route('home') }}" class="btn btn-primary">{{ __('Browse Products') }}</a>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Quantity') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Subtotal') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['product']->name }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>
                            @if ($item['product']->has_discount)
                                <span class="text-muted text-decoration-line-through small d-block">
                                    ${{ number_format($item['product']->price, 2) }}
                                </span>
                                <span class="text-danger">${{ number_format($item['product']->final_price, 2) }}</span>
                            @else
                                ${{ number_format($item['product']->price, 2) }}
                            @endif
                        </td>
                        <td>${{ number_format($item['subtotal'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('Remove') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3"><strong>{{ __('Total') }}</strong></td>
                    <td colspan="2">${{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">{{ __('Proceed to Checkout') }}</a>
    @endif

@endsection
