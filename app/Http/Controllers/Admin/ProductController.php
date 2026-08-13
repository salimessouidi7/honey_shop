<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('catalog')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $catalogs = Catalog::orderBy('name')->get();
        return view('admin.products.create', compact('catalogs'));
    }

    public function store(Request $request)
    {
        Product::create($this->validated($request));
        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $catalogs = Catalog::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'catalogs'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request));
        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    // Only reachable by admins - the route itself is protected by role:admin middleware
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'catalog_id'      => ['nullable', 'exists:catalogs,id'],
            'name'            => ['required', 'string', 'max:255'],
            'honey_type'      => ['nullable', 'string', 'max:255'],
            'description'     => ['nullable', 'string'],
            'price'           => ['required', 'numeric', 'min:0'],
            'discount_type'   => ['nullable', 'in:percent,fixed'],
            'discount_value'  => ['nullable', 'numeric', 'min:0'],
            'stock'           => ['required', 'integer', 'min:0'],
            'image_url'       => ['nullable', 'string', 'max:500'],
        ]);

        // A percentage discount can never exceed 100%
        if (($validated['discount_type'] ?? null) === 'percent' && ($validated['discount_value'] ?? 0) > 100) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'discount_value' => 'A percentage discount cannot exceed 100.',
            ]);
        }

        // If no discount type is selected, make sure no stray discount value survives
        if (empty($validated['discount_type'])) {
            $validated['discount_type'] = null;
            $validated['discount_value'] = null;
        }

        return $validated;
    }
}
