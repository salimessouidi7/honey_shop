<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\OrderStatusUpdated;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    // Both admin and staff can update status - no delete route exists for orders at all,
    // "cancelled" is just another status rather than a destructive action.
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,shipped,completed,cancelled'],
        ]);

        $order->update($validated);

        // Only fires if the order belongs to a logged-in customer - guests
        // have no account to notify.
        if ($order->user_id) {
            $order->user->notify(new OrderStatusUpdated($order));
        }

        return back()->with('success', 'Order status updated.');
    }
}
