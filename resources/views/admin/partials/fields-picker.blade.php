<div class="mb-3">
    <label class="form-label">المجالات</label>
    <div style="background:var(--bg-input);border:1px solid var(--border);border-radius:12px;padding:1rem;">
        <div class="row g-2">
            @forelse($fields as $field)
                <div class="col-md-6 col-lg-4">
                    <label class="form-check" style="cursor:pointer;">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="field_ids[]"
                            value="{{ $field->id }}"
                            {{ in_array($field->id, $selectedFieldIds ?? []) ? 'checked' : '' }}
                        >
                        <span class="form-check-label" style="font-weight:600;">{{ $field->name }}</span>
                    </label>
                </div>
            @empty
                <div class="col-12">
                    <div style="color:var(--text-muted);font-size:.85rem;">لا توجد مجالات مضافة بعد.</div>
                </div>
            @endforelse
        </div>
    </div>
    <small style="font-size:.75rem;color:var(--text-muted);margin-top:4px;display:block;">إذا لم تحدد أي مجال، فسيُعتبر التصنيف متاحًا في كل المجالات.</small>
    @error('field_ids')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
