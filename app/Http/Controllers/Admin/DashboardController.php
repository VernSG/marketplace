<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Calculate total revenue from completed orders
        $total_revenue = Order::where('status', 'completed')
            ->sum('total_amount');

        // Count active shops (shops that have at least one product)
        $active_shops_count = Shop::has('products')
            ->count();

        // Count orders created today
        $daily_orders = Order::whereDate('created_at', Carbon::today())
            ->count();

        return view('admin.dashboard', compact(
            'total_revenue',
            'active_shops_count',
            'daily_orders'
        ));
    }
}
