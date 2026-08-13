<?php

namespace App\Http\Controllers;

use App\Models\Catalog;

class CatalogController extends Controller
{
    // Laravel's route-model binding automatically fetches the Catalog
    // by {catalog} in the URL, or throws a 404 if it doesn't exist
    // (no more manual "if (!$catalog) redirect" checks needed).
    public function show(Catalog $catalog)
    {
        $products = $catalog->products()->where('stock', '>', 0)->get();

        return view('catalog', compact('catalog', 'products'));
    }
}
