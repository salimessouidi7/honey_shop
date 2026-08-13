<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockAlert;
use App\Notifications\NewOrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('home');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $subtotal = 0;
        foreach ($cart as $id => $qty) {
            $product = $products->get($id);
            if (!$product) continue;

            if ($qty > $product->stock) {
                return back()->with('error', "Insufficient stock for {$product->name}");
            }

            $subtotal += $product->final_price * $qty;
        }

        $discountPercent = $request->user()?->loyaltyDiscountPercent() ?? 0;
        $discountAmount = round($subtotal * $discountPercent / 100, 2);
        $total = $subtotal - $discountAmount;

        return view('checkout', compact('subtotal', 'discountPercent', 'discountAmount', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_name'    => ['required', 'string', 'max:255'],
            'guest_email'   => ['required', 'email', 'max:255'],
            'guest_phone'   => ['nullable', 'string', 'max:30'],
            'guest_address' => ['required', 'string', 'max:1000'],
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('home');
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        // Re-check stock right before placing the order (it may have changed
        // since the cart page loaded)
        $subtotal = 0;
        foreach ($cart as $id => $qty) {
            $product = $products->get($id);
            if (!$product || $qty > $product->stock) {
                return back()->with('error', 'Sorry, one of the items in your cart is no longer available in that quantity.');
            }
            $subtotal += $product->final_price * $qty;
        }

        $discountPercent = $request->user()?->loyaltyDiscountPercent() ?? 0;
        $discountAmount = round($subtotal * $discountPercent / 100, 2);
        $total = $subtotal - $discountAmount;

        // DB::transaction replaces the manual beginTransaction/commit/rollBack
        // try-catch block from the old checkout.php
        $lowStockThreshold = 5;
        $lowStockProducts = [];

        $order = DB::transaction(function () use ($cart, $products, $subtotal, $discountPercent, $discountAmount, $total, $validated, $request, $lowStockThreshold, &$lowStockProducts) {
            $order = Order::create([
                'user_id'          => $request->user()?->id, // null for guests, filled in if logged in
                'guest_name'       => $validated['guest_name'],
                'guest_email'      => $validated['guest_email'],
                'guest_phone'      => $validated['guest_phone'] ?? null,
                'guest_address'    => $validated['guest_address'],
                'subtotal'         => $subtotal,
                'discount_percent' => $discountPercent,
                'discount_amount'  => $discountAmount,
                'total'            => $total,
                'status'           => 'pending',
            ]);

            foreach ($cart as $id => $qty) {
                $product = $products->get($id);

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->final_price,
                ]);

                $product->decrement('stock', $qty);

                if ($product->fresh()->stock <= $lowStockThreshold) {
                    $lowStockProducts[] = $product;
                }
            }

            return $order;
        });

        session()->forget('cart');

        // Notify admin/staff - the new order, and any product that just crossed into low stock
        $staff = User::whereIn('role', ['admin', 'staff'])->get();
        Notification::send($staff, new NewOrderPlaced($order));

        foreach ($lowStockProducts as $product) {
            Notification::send($staff, new LowStockAlert($product));
        }

        return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order)
    {
        // Guests can view their own just-placed order via the session-issued redirect;
        // logged-in users can only view it if it's theirs.
        if ($order->user_id && $order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout-success', compact('order'));
    }
}
