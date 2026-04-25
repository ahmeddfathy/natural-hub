@csrf

<div class="shop-form-grid">
    <div class="shop-field shop-field--wide">
        <label>اسم المنتج <span>*</span></label>
        <div class="shop-control">
            <i class="fas fa-tag"></i>
            <input type="text" name="name" class="@error('name') is-invalid @enderror" value="{{ old('name', $product->name ?? '') }}" required>
        </div>
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>السعر <span>*</span></label>
        <div class="shop-control">
            <i class="fas fa-coins"></i>
            <input type="number" name="price" class="@error('price') is-invalid @enderror" value="{{ old('price', $product->price ?? 0) }}" min="0" required>
        </div>
        @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>الترتيب</label>
        <div class="shop-control">
            <i class="fas fa-sort-numeric-down"></i>
            <input type="number" name="sort_order" class="@error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $product->sort_order ?? 0) }}" min="0">
        </div>
        @error('sort_order')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>الحجم/العبوة</label>
        <div class="shop-control">
            <i class="fas fa-ruler-combined"></i>
            <input type="text" name="size_label" class="@error('size_label') is-invalid @enderror" value="{{ old('size_label', $product->size_label ?? '') }}" placeholder="مثال: 100 مل">
        </div>
        @error('size_label')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>المجموعة</label>
        <div class="shop-control">
            <i class="fas fa-layer-group"></i>
            <select name="bundle_id" class="@error('bundle_id') is-invalid @enderror">
                <option value="">منتج مستقل</option>
                @foreach($bundles as $bundle)
                    <option value="{{ $bundle->id }}" {{ (string) old('bundle_id', $product->bundle_id ?? '') === (string) $bundle->id ? 'selected' : '' }}>
                        {{ $bundle->name }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('bundle_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>الصورة</label>
        <div class="shop-file-control">
            <input type="file" name="image" class="@error('image') is-invalid @enderror" accept="image/*">
        </div>
        @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field shop-field--full">
        <label>الوصف</label>
        <div class="shop-control shop-control--textarea">
            <textarea name="description" class="@error('description') is-invalid @enderror" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
        </div>
        @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-switch-card">
        <input type="hidden" name="in_stock" value="0">
        <input class="form-check-input" type="checkbox" name="in_stock" id="in_stock" value="1" {{ old('in_stock', $product->in_stock ?? true) ? 'checked' : '' }}>
        <label for="in_stock">
            <strong>متوفر في المخزون</strong>
            <small>يظهر للعميلات كمنتج قابل للطلب</small>
        </label>
    </div>

    <div class="shop-switch-card">
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active">
            <strong>ظاهر في المتجر</strong>
            <small>إيقافها يخفي المنتج من الواجهة</small>
        </label>
    </div>
</div>

<div class="shop-form-actions">
    <a href="{{ route('admin.shop.index') }}" class="shop-secondary-btn">رجوع</a>
    <button type="submit" class="shop-action-btn">
        <i class="fas fa-save"></i>
        حفظ
    </button>
</div>
