<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []); // [product_id => quantity]

        if (empty($cart)) {
            return view('cart', ['items' => [], 'total' => 0]);
        }

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $id => $qty) {
            $product = $products->get($id);
            if (!$product) continue;

            $subtotal = $product->final_price * $qty;
            $total += $subtotal;

            $items[] = [
                'product'  => $product,
                'quantity' => $qty,
                'subtotal' => $subtotal,
            ];
        }

        return view('cart', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:' . $product->stock],
        ]);

        $cart = session('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + (int) $request->quantity;
        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index');
    }
}
