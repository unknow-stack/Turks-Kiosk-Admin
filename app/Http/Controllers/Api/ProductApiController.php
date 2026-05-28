<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category:id,name,slug')
            ->where('is_available', true)
            ->where('stock_status', '!=', 'out_of_stock')
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'ilike', '%' . $request->search . '%');
            })
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        return response()->json($products);
    }

    public function show(Product $product)
    {
        abort_unless($product->is_available, 404);

        return response()->json($product->load('category:id,name,slug'));
    }
}
