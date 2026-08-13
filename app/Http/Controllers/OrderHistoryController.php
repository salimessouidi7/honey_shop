<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Make sure customers can only ever see their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('orders.show', compact('order'));
    }
}
