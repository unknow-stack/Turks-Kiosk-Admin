<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div class="form-grid">
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" required>
                <option value="">Select category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Product Name</label>
            <input class="input" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>SKU</label>
            <input class="input" name="sku" value="{{ old('sku', $product->sku ?? '') }}" placeholder="TK-PITA-BEEF">
            @error('sku')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Price</label>
            <input class="input" type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}" required>
            @error('price')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Stock Status</label>
            <select name="stock_status" required>
                @foreach(['in_stock' => 'In Stock', 'limited' => 'Limited', 'out_of_stock' => 'Out of Stock'] as $key => $label)
                    <option value="{{ $key }}" @selected(old('stock_status', $product->stock_status ?? 'in_stock') === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Display Order</label>
            <input class="input" type="number" min="0" name="display_order" value="{{ old('display_order', $product->display_order ?? 0) }}">
        </div>
        <div class="form-group full">
            <label>Description</label>
            <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Image URL</label>
            <input class="input" type="url" name="image_url" value="{{ old('image_url', $product->image_url ?? '') }}" placeholder="https://...">
            @error('image_url')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Upload Image</label>
            <input class="input" type="file" name="image" accept="image/*">
            @error('image')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group full">
            <label class="checkbox-line"><input type="checkbox" name="is_available" value="1" @checked(old('is_available', $product->is_available ?? true))> Available on menu</label>
            <label class="checkbox-line"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))> Featured menu item</label>
        </div>
    </div>
    <div class="actions mt-20"><button class="btn btn-primary">Save Product</button></div>
</form>
