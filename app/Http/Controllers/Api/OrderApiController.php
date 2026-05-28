<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderApiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:120'],
            'customer_contact' => ['nullable', 'string', 'max:80'],
            'order_type' => ['nullable', Rule::in(['kiosk', 'mobile'])],
            'payment_method' => ['nullable', Rule::in(['cash', 'gcash', 'card', 'mock'])],
            'payment_status' => ['nullable', Rule::in(Order::PAYMENT_STATUSES)],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $productIds = collect($data['items'])->pluck('product_id')->unique()->values();
            $products = Product::whereIn('id', $productIds)
                ->where('is_available', true)
                ->where('stock_status', '!=', 'out_of_stock')
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $items = [];

            foreach ($data['items'] as $item) {
                $product = $products->get($item['product_id']);

                if (! $product) {
                    abort(response()->json([
                        'message' => 'One or more selected products are unavailable.',
                    ], 422));
                }

                $lineSubtotal = (float) $product->price * (int) $item['quantity'];
                $subtotal += $lineSubtotal;

                $items[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $lineSubtotal,
                ];
            }

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => $data['customer_name'] ?? 'Guest',
                'customer_contact' => $data['customer_contact'] ?? null,
                'order_type' => $data['order_type'] ?? 'kiosk',
                'payment_method' => $data['payment_method'] ?? 'cash',
                'payment_status' => $data['payment_status'] ?? 'unpaid',
                'status' => 'pending',
                'subtotal_amount' => $subtotal,
                'discount_amount' => 0,
                'total_amount' => $subtotal,
                'notes' => $data['notes'] ?? null,
            ]);

            $order->items()->createMany($items);

            return $order->load('items');
        });

        return response()->json([
            'message' => 'Order placed successfully.',
            'order' => $order,
        ], 201);
    }

    public function show(string $orderNumber)
    {
        $order = Order::with('items.product:id,name,image_path,image_url')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return response()->json($order);
    }
}
