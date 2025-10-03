<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_customers' => User::where('user_type', 'customer')->count(),
            'pending_customers' => User::where('user_type', 'customer')->where('status', 'pending')->count(),
            'approved_customers' => User::where('user_type', 'customer')->where('status', 'approved')->count(),
            'total_products' => Product::count(),
            'active_products' => Product::where('active', true)->count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
        ];

        $pending_customers = User::where('user_type', 'customer')
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        $recent_orders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'pending_customers', 'recent_orders'));
    }
}
