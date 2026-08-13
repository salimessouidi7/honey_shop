<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::withCount('products')->orderBy('name')->get();
        return view('admin.catalogs.index', compact('catalogs'));
    }

    public function create()
    {
        return view('admin.catalogs.create');
    }

    public function store(Request $request)
    {
        Catalog::create($this->validated($request));
        return redirect()->route('admin.catalogs.index')->with('success', 'Catalog created.');
    }

    public function edit(Catalog $catalog)
    {
        return view('admin.catalogs.edit', compact('catalog'));
    }

    public function update(Request $request, Catalog $catalog)
    {
        $catalog->update($this->validated($request));
        return redirect()->route('admin.catalogs.index')->with('success', 'Catalog updated.');
    }

    // Admin-only route
    public function destroy(Catalog $catalog)
    {
        $catalog->delete(); // products.catalog_id is nullOnDelete, so products aren't lost
        return redirect()->route('admin.catalogs.index')->with('success', 'Catalog deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);
    }
}
