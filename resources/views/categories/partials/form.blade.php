<form method="POST" action="{{ $action }}">
    @csrf
    @if($method !== 'POST') @method($method) @endif
    <div class="form-grid">
        <div class="form-group">
            <label>Name</label>
            <input class="input" name="name" value="{{ old('name', $category->name ?? '') }}" required>
            @error('name')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label>Display Order</label>
            <input class="input" type="number" name="display_order" min="0" value="{{ old('display_order', $category->display_order ?? 0) }}">
            @error('display_order')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group full">
            <label>Description</label>
            <textarea name="description">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')<div class="error-text">{{ $message }}</div>@enderror
        </div>
        <div class="form-group full">
            <label class="checkbox-line"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> Active category</label>
        </div>
    </div>
    <div class="actions mt-20"><button class="btn btn-primary">Save Category</button></div>
</form>
