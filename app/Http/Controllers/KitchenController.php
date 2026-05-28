<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KitchenController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->whereIn('status', ['pending', 'preparing', 'ready'])
            ->orderByRaw("CASE status WHEN 'pending' THEN 1 WHEN 'preparing' THEN 2 WHEN 'ready' THEN 3 ELSE 4 END")
            ->oldest()
            ->get()
            ->groupBy('status');

        return view('kitchen.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['preparing', 'ready', 'completed', 'cancelled'])],
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', "Order {$order->order_number} moved to " . str($data['status'])->headline() . '.');
    }
}
