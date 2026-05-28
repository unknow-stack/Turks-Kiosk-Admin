<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->date('start_date') ?? now()->startOfMonth();
        $endDate = $request->date('end_date') ?? now()->endOfMonth();

        $ordersQuery = Order::whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay(),
        ]);

        $completedOrders = (clone $ordersQuery)->where('status', 'completed');

        $summary = [
            'gross_sales' => (clone $completedOrders)->sum('total_amount'),
            'completed_orders' => (clone $completedOrders)->count(),
            'cancelled_orders' => (clone $ordersQuery)->where('status', 'cancelled')->count(),
            'active_orders' => (clone $ordersQuery)->whereIn('status', ['pending', 'preparing', 'ready'])->count(),
            'average_order_value' => round((clone $completedOrders)->avg('total_amount') ?? 0, 2),
        ];

        $dailySales = (clone $completedOrders)
            ->select(DB::raw('DATE(created_at) as sales_date'), DB::raw('SUM(total_amount) as sales'), DB::raw('COUNT(*) as order_count'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sales_date')
            ->get();

        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal) as total_sales'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ])
            ->groupBy('product_name')
            ->orderByDesc('total_sales')
            ->limit(10)
            ->get();

        return view('reports.index', compact('summary', 'dailySales', 'topProducts', 'startDate', 'endDate'));
    }
}
