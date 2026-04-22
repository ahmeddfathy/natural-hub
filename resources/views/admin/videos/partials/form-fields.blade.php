{{-- ─── Video Form Fields ─────────────────────────────────────────────── --}}
@php $isEdit = isset($video) && $video; @endphp

{{-- العنوان --}}
<div class="mb-3">
    <label class="form-label">العنوان <span class="text-danger">*</span></label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $video->title ?? '') }}" required>
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

{{-- رابط اليوتيوب --}}
<div class="mb-3">
    <label class="form-label">رابط YouTube <span class="text-danger">*</span></label>
    <input type="url" name="youtube_url" dir="ltr"
           class="form-control @error('youtube_url') is-invalid @enderror"
           value="{{ old('youtube_url', $video->youtube_url ?? '') }}"
           placeholder="https://www.youtube.com/watch?v=..."
           required>
    <div class="form-text">يدعم روابط Watch, Shorts, وEmbed فقط — لا يدعم Google Drive</div>
    @error('youtube_url')<div class="invalid-feedback">{{ $message }}</div>@enderror

    {{-- Preview --}}
    @if($isEdit && $video->youtube_video_id)
    <div class="mt-2">
        <img src="https://img.youtube.com/vi/{{ $video->youtube_video_id }}/mqdefault.jpg"
             alt="thumbnail" class="rounded" style="width:180px;">
    </div>
    @endif
</div>

{{-- القسم + الخدمة المرتبطة --}}
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <label class="form-label">القسم <span class="text-danger">*</span></label>
        <select name="category_type" id="catSelect"
                class="form-select @error('category_type') is-invalid @enderror"
                required onchange="filterServices(this.value)">
            <option value="">اختاري القسم...</option>
            @foreach($categories as $key => $label)
                <option value="{{ $key }}" {{ old('category_type', $video->category_type ?? '') == $key ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('category_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-5">
        <label class="form-label">الخدمة المرتبطة <span class="text-muted small">(اختياري)</span></label>
        <select name="service_id" id="serviceSelect" class="form-select @error('service_id') is-invalid @enderror">
            <option value="">— لا خدمة محددة —</option>
            @foreach($services as $service)
                <option value="{{ $service->id }}"
                        data-cat="{{ $service->category_type }}"
                        {{ old('service_id', $video->service_id ?? '') == $service->id ? 'selected' : '' }}>
                    {{ $service->title }} ({{ $service->category_type }})
                </option>
            @endforeach
        </select>
        @error('service_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-3">
        <label class="form-label">الترتيب</label>
        <input type="number" name="sort_order" class="form-control" min="0"
               value="{{ old('sort_order', $video->sort_order ?? 0) }}">
    </div>
</div>

{{-- الملخص --}}
<div class="mb-3">
    <label class="form-label">ملخص قصير</label>
    <textarea name="excerpt" rows="2"
              class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $video->excerpt ?? '') }}</textarea>
    @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

{{-- الخيارات --}}
<div class="row g-3 mb-3">
    <div class="col-md-3 d-flex align-items-center gap-2">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                   {{ old('is_featured', $video->is_featured ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">مميز</label>
        </div>
    </div>
    <div class="col-md-3 d-flex align-items-center gap-2">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="is_portrait" value="1"
                   {{ old('is_portrait', $video->is_portrait ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">رأسي (Portrait)</label>
        </div>
    </div>
    <div class="col-md-3 d-flex align-items-center gap-2">
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" name="is_published" value="1"
                   {{ old('is_published', $video->is_published ?? true) ? 'checked' : '' }}>
            <label class="form-check-label">منشور</label>
        </div>
    </div>
</div>

{{-- Buttons --}}
<div class="blogs-form-actions">
    <a href="{{ route('admin.videos.index') }}" class="blogs-back-btn">رجوع</a>
    <div class="d-flex gap-2">
        <button type="submit" name="save_as_draft" value="1" class="blogs-draft-btn">حفظ كمسودة</button>
        <button type="submit" class="blogs-save-btn">
            {{ $isEdit ? 'حفظ التعديلات' : 'إضافة الفيديو' }}
        </button>
    </div>
</div>

<script>
function filterServices(cat) {
    document.querySelectorAll('#serviceSelect option[data-cat]').forEach(opt => {
        opt.hidden = cat && opt.dataset.cat !== cat;
    });
    // reset if hidden
    const sel = document.getElementById('serviceSelect');
    const chosen = sel.options[sel.selectedIndex];
    if (chosen && chosen.hidden) sel.value = '';
}
// run on load
document.addEventListener('DOMContentLoaded', () => filterServices(document.getElementById('catSelect')?.value));
</script>
