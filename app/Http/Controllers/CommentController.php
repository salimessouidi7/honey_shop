<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductComment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'body'   => ['required', 'string', 'max:2000'],
        ]);

        ProductComment::create([
            'product_id' => $product->id,
            'user_id'    => $request->user()->id,
            'rating'     => $validated['rating'] ?? null,
            'body'       => $validated['body'],
        ]);

        return back()->with('success', 'Thanks for your feedback!');
    }
}
