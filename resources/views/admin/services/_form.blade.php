@php
    $isEdit = isset($service);
    $serviceFeaturesValue = old(
        'features_text',
        isset($service)
            ? (is_array($service->features ?? null) ? implode(', ', $service->features ?? []) : ($service->features ?? ''))
            : ''
    );
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">عنوان الخدمة <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $service->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">ترتيب الظهور</label>
        <input type="number" min="0" name="sort_order" class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $service->sort_order ?? 0) }}">
        @error('sort_order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">وصف الخدمة <span class="text-danger">*</span></label>
        <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $service->description ?? '') }}</textarea>
        @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">ميزات الخدمة</label>
        <input type="hidden" name="features_text" id="service_features_hidden" value="{{ $serviceFeaturesValue }}">
        <div class="tag-input-container service-tag-input @error('features_text') is-invalid @enderror"
             id="service_features_taginput" data-target="service_features_hidden">
            <input type="text" class="tag-input-field" placeholder="اكتب ميزة واضغط Enter...">
            <div class="tag-input-hint"><kbd>Enter</kbd> أو <kbd>,</kbd> لإضافة</div>
            <div class="tag-chips-area"></div>
        </div>
        @error('features_text')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">صورة الخدمة</label>
        <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
        <small class="text-muted">الحد الأقصى: 10 ميجابايت</small>
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">النص البديل للصورة</label>
        <input type="text" name="image_alt" class="form-control @error('image_alt') is-invalid @enderror"
               value="{{ old('image_alt', $service->image_alt ?? '') }}">
        @error('image_alt')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if($isEdit && $service->image)
        <div class="col-12">
            <div class="service-current-image">
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->image_alt ?: $service->title }}">
            </div>
        </div>
    @endif

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
                {{ old('is_active', $service->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">إظهار الخدمة في الموقع</label>
        </div>
    </div>

    <div class="col-12 d-flex justify-content-between align-items-center mt-3">
        <a href="{{ route('admin.services.index') }}" class="btn btn-light border">رجوع</a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            {{ $isEdit ? 'حفظ التعديلات' : 'حفظ الخدمة' }}
        </button>
    </div>
</div>

@once
    <script>
        function addServiceFeatureChip(container, value) {
            value = value.trim();
            if (!value) {
                return;
            }

            var chipsArea = container.querySelector('.tag-chips-area');
            var existing = chipsArea.querySelectorAll('.tag-chip-text');

            for (var i = 0; i < existing.length; i++) {
                if (existing[i].textContent.trim() === value) {
                    return;
                }
            }

            var chip = document.createElement('span');
            chip.className = 'tag-chip';

            var text = document.createElement('span');
            text.className = 'tag-chip-text';
            text.textContent = value;

            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'tag-chip-remove';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.addEventListener('click', function () {
                chip.remove();
                syncServiceFeatures(container);
            });

            chip.appendChild(text);
            chip.appendChild(removeBtn);
            chipsArea.appendChild(chip);

            syncServiceFeatures(container);
        }

        function syncServiceFeatures(container) {
            var values = Array.from(container.querySelectorAll('.tag-chip-text'))
                .map(function (chip) {
                    return chip.textContent.trim();
                })
                .filter(function (value) {
                    return value;
                });

            document.getElementById(container.dataset.target).value = values.join(',');
        }

        function splitServiceFeatures(value) {
            return value
                .split(/[\n\r,،]+/)
                .map(function (item) {
                    return item.trim();
                })
                .filter(function (item) {
                    return item;
                });
        }

        function initServiceFeaturesTagInput() {
            var container = document.getElementById('service_features_taginput');
            if (!container || container.dataset.initialized === 'true') {
                return;
            }

            container.dataset.initialized = 'true';

            var input = container.querySelector('.tag-input-field');
            var hiddenInput = document.getElementById(container.dataset.target);
            var initialValue = hiddenInput ? hiddenInput.value : '';

            splitServiceFeatures(initialValue).forEach(function (value) {
                addServiceFeatureChip(container, value);
            });

            input.addEventListener('keydown', function (event) {
                if (event.key === 'Enter' || event.key === ',') {
                    event.preventDefault();

                    var value = input.value.replace(/[،,]/g, ' ').trim();
                    if (value) {
                        addServiceFeatureChip(container, value);
                        input.value = '';
                    }
                }

                if (event.key === 'Backspace' && !input.value) {
                    var chips = container.querySelectorAll('.tag-chip');
                    if (chips.length > 0) {
                        chips[chips.length - 1].remove();
                        syncServiceFeatures(container);
                    }
                }
            });

            input.addEventListener('paste', function (event) {
                event.preventDefault();

                var pastedValue = (event.clipboardData || window.clipboardData).getData('text');
                splitServiceFeatures(pastedValue).forEach(function (value) {
                    addServiceFeatureChip(container, value);
                });
                input.value = '';
            });

            input.addEventListener('blur', function () {
                var value = input.value.replace(/[،,]/g, ' ').trim();
                if (value) {
                    addServiceFeatureChip(container, value);
                    input.value = '';
                }
            });

            var form = container.closest('form');
            if (form) {
                form.addEventListener('submit', function () {
                    syncServiceFeatures(container);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', initServiceFeaturesTagInput);
    </script>
@endonce
