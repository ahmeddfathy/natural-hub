@csrf

<div class="shop-form-grid">
    <div class="shop-field shop-field--wide">
        <label>اسم المجموعة <span>*</span></label>
        <div class="shop-control">
            <i class="fas fa-layer-group"></i>
            <input type="text" name="name" class="@error('name') is-invalid @enderror" value="{{ old('name', $bundle->name ?? '') }}" required>
        </div>
        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>السعر <span>*</span></label>
        <div class="shop-control">
            <i class="fas fa-coins"></i>
            <input type="number" name="price" class="@error('price') is-invalid @enderror" value="{{ old('price', $bundle->price ?? 0) }}" min="0" required>
        </div>
        @error('price')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>الترتيب</label>
        <div class="shop-control">
            <i class="fas fa-sort-numeric-down"></i>
            <input type="number" name="sort_order" class="@error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $bundle->sort_order ?? 0) }}" min="0">
        </div>
        @error('sort_order')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>لون/نوع المجموعة</label>
        <div class="shop-control">
            <i class="fas fa-palette"></i>
            <input type="text" name="color_variant" class="@error('color_variant') is-invalid @enderror" value="{{ old('color_variant', $bundle->color_variant ?? '') }}" placeholder="مثال: Pink / Green">
        </div>
        @error('color_variant')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-field">
        <label>الصورة</label>
        <div class="shop-file-control">
            <input type="file" name="image" class="@error('image') is-invalid @enderror" accept="image/*">
        </div>
        @error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        @isset($bundle)
            @if($bundle->image)
                <div class="form-text">اتركيها فارغة للاحتفاظ بالصورة الحالية.</div>
            @endif
        @endisset
    </div>

    <div class="shop-field shop-field--full">
        <label>الوصف</label>
        <div class="shop-control shop-control--textarea">
            <textarea name="description" class="@error('description') is-invalid @enderror" rows="4">{{ old('description', $bundle->description ?? '') }}</textarea>
        </div>
        @error('description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>

    <div class="shop-switch-card shop-field--full">
        <input type="hidden" name="is_active" value="0">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $bundle->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active">
            <strong>ظاهرة في المتجر</strong>
            <small>إيقافها يخفي المجموعة من الواجهة</small>
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
