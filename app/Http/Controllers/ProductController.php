<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('display_order')->orderBy('name')->get();

        $products = Product::with('category')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'ilike', '%' . $request->search . '%')
                        ->orWhere('sku', 'ilike', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('availability'), function ($query) use ($request) {
                if ($request->availability === 'available') {
                    $query->where('is_available', true);
                }

                if ($request->availability === 'unavailable') {
                    $query->where('is_available', false);
                }
            })
            ->orderBy('display_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('display_order')->orderBy('name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Str::slug($data['name']);
        $data['is_available'] = $request->boolean('is_available', true);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('display_order')->orderBy('name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validatedData($request, $product);
        $data['slug'] = Str::slug($data['name']);
        $data['is_available'] = $request->boolean('is_available');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }

            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            $product->update(['is_available' => false]);

            return back()->with('success', 'Product already has order history, so it was marked unavailable instead of deleted.');
        }

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_available' => ! $product->is_available]);

        return back()->with('success', 'Product availability updated.');
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:160'],
            'sku' => ['nullable', 'string', 'max:80', Rule::unique('products', 'sku')->ignore($product)],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'image' => ['nullable', 'image', 'max:4096'],
            'stock_status' => ['required', Rule::in(['in_stock', 'limited', 'out_of_stock'])],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'is_available' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);
    }
}
