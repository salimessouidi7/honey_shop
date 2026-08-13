<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $catalogs = Catalog::orderBy('name')->get();
        $products = Product::where('stock', '>', 0)->latest()->get();

        return view('home', compact('catalogs', 'products'));
    }
}
