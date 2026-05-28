<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::withCount('items')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('date'), fn ($query) => $query->whereDate('created_at', $request->date))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = Order::STATUSES;

        return view('orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        $statuses = Order::STATUSES;

        return view('orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(Order::STATUSES)],
            'payment_status' => ['nullable', Rule::in(Order::PAYMENT_STATUSES)],
        ]);

        $order->update([
            'status' => $data['status'],
            'payment_status' => $data['payment_status'] ?? $order->payment_status,
        ]);

        return back()->with('success', 'Order status updated.');
    }

    public function receipt(Order $order)
    {
        $order->load('items');

        return view('orders.receipt', compact('order'));
    }
}
