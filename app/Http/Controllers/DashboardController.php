<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'products' => Product::count(),
            'available_products' => Product::where('is_available', true)->count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'active_orders' => Order::whereIn('status', ['pending', 'preparing', 'ready'])->count(),
            'completed_sales' => Order::where('status', 'completed')->sum('total_amount'),
        ];

        $latestOrders = Order::with('items')
            ->latest()
            ->limit(8)
            ->get();

        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(subtotal) as total_sales'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'completed')
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        return view('dashboard', compact('stats', 'latestOrders', 'topProducts'));
    }
}
