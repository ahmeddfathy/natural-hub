<div class="mb-3">
    <label class="form-label">المجالات</label>
    <div class="border rounded-3 p-3">
        <div class="row g-2">
            @forelse($fields as $field)
                <div class="col-md-6 col-lg-4">
                    <label class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="field_ids[]"
                            value="{{ $field->id }}"
                            {{ in_array($field->id, $selectedFieldIds ?? []) ? 'checked' : '' }}
                        >
                        <span class="form-check-label">{{ $field->name }}</span>
                    </label>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-muted">لا توجد مجالات مضافة بعد.</div>
                </div>
            @endforelse
        </div>
    </div>
    <small class="text-muted">إذا لم تحدد أي مجال، فسيُعتبر التصنيف متاحًا في كل المجالات.</small>
    @error('field_ids')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
