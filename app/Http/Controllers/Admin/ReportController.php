<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->filled('date_from')
            ? \Carbon\Carbon::parse($request->date_from)->startOfDay()
            : now()->startOfMonth();

        $to = $request->filled('date_to')
            ? \Carbon\Carbon::parse($request->date_to)->endOfDay()
            : now()->endOfDay();

        $baseQuery = Order::whereBetween('created_at', [$from, $to])
            ->whereNotIn('status', ['rejected', 'cancelled']);

        // Summary cards
        $totalRevenue = (clone $baseQuery)->sum('total');
        $totalOrders  = (clone $baseQuery)->count();
        $avgTicket    = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Sales by day for chart
        $salesByDay = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Build full date range
        $dateRange = [];
        $cursor = $from->copy();
        while ($cursor->lte($to)) {
            $key = $cursor->toDateString();
            $dateRange[$key] = [
                'date'    => $cursor->format('d/m'),
                'revenue' => $salesByDay[$key]->revenue ?? 0,
                'count'   => $salesByDay[$key]->count ?? 0,
            ];
            $cursor->addDay();
        }

        // Top 10 products
        $topProducts = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->whereNotIn('orders.status', ['rejected', 'cancelled'])
            ->selectRaw('product_name, product_sku, SUM(quantity) as total_qty, SUM(total_price) as total_revenue')
            ->groupBy('product_name', 'product_sku')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // Sales by category
        $byCategory = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$from, $to])
            ->whereNotIn('orders.status', ['rejected', 'cancelled'])
            ->selectRaw('categories.name as category, SUM(order_items.total_price) as revenue')
            ->groupBy('categories.name')
            ->orderByDesc('revenue')
            ->get();

        // Orders by status (doughnut)
        $byStatus = Order::whereBetween('created_at', [$from, $to])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.reports.index', compact(
            'from', 'to',
            'totalRevenue', 'totalOrders', 'avgTicket',
            'dateRange', 'topProducts', 'byCategory', 'byStatus'
        ));
    }
}
