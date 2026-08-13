<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [
            'products' => Product::count(),

            'catalogs' => Catalog::count(),

            'orders' => Order::count(),

            'pending_orders' => Order::where('status', 'pending')->count(),

            'revenue' => Order::whereIn('status', [
                'paid',
                'shipped',
                'completed',
            ])->sum('total'),

            'admins' => User::count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | Recent Orders
        |--------------------------------------------------------------------------
        */

        $allowedStatuses = [
            'pending',
            'paid',
            'shipped',
            'completed',
            'cancelled',
        ];


        $status = $request->query('status');


        $recentOrdersQuery = Order::latest();


        /*
        |--------------------------------------------------------------------------
        | Apply Status Filter
        |--------------------------------------------------------------------------
        */

        if ($status && in_array($status, $allowedStatuses)) {

            $recentOrdersQuery->where('status', $status);

        } else {

            // Ignore invalid status values
            $status = null;

        }


        /*
        |--------------------------------------------------------------------------
        | Get Orders
        |--------------------------------------------------------------------------
        */

        $recentOrders = $recentOrdersQuery
            ->take(10)
            ->get();


        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'status'
        ));
    }
}
