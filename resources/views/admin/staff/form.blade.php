@php $isEdit = isset($staff); @endphp

<div class="ops-banner">
    <div class="ops-banner-top">
        <div class="ops-banner-title">
            <i class="fas {{ $isEdit ? 'fa-edit' : 'fa-user-plus' }} ic-staff"></i>
            <div>
                <h4>{{ $isEdit ? 'تعديل: ' . $staff->name : 'إضافة موظفة جديدة' }}</h4>
                <p>{{ $isEdit ? 'تحديث بيانات الموظفة' : 'أضيفي موظفة جديدة للمركز' }}</p>
            </div>
        </div>
        <a href="{{ route('admin.staff.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.5rem 1.25rem;border-radius:10px;font-weight:700;font-size:.82rem;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);text-decoration:none;">
            <i class="fas fa-arrow-right"></i> العودة
        </a>
    </div>
</div>

<div class="ops-detail-panel">
    <div class="ops-detail-header"><i class="fas fa-user-tie"></i> بيانات الموظفة</div>

    @if($errors->any())
        <div style="background:rgba(220,38,38,.06);color:#dc2626;border:1px solid rgba(220,38,38,.12);padding:1rem;border-radius:12px;margin-bottom:1.5rem;font-size:.88rem;">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $isEdit ? route('admin.staff.update', $staff) : route('admin.staff.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="row g-3">
            @if($isEdit && $staff->avatar)
            <div class="col-12">
                <div class="ops-avatar" style="width:80px;height:80px;border-radius:16px;">
                    <img src="{{ $staff->avatar_url }}" alt="{{ $staff->name }}">
                </div>
            </div>
            @endif

            <div class="col-md-6">
                <label class="form-label">الاسم <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $staff->name ?? '') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">الفرع <span style="color:#dc2626;">*</span></label>
                <select name="branch_id" class="form-select" required>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id', $staff->branch_id ?? '') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">التخصص</label>
                <input type="text" name="specialty" class="form-control" value="{{ old('specialty', $staff->specialty ?? '') }}" placeholder="شعر / بشرة / رموش / الكل">
            </div>
            <div class="col-md-4">
                <label class="form-label">رقم الموبايل</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $staff->phone ?? '') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">الحالة <span style="color:#dc2626;">*</span></label>
                <select name="status" class="form-select" required>
                    <option value="active"   {{ old('status', $staff->status ?? 'active') == 'active'   ? 'selected':'' }}>نشطة</option>
                    <option value="on_leave" {{ old('status', $staff->status ?? '') == 'on_leave' ? 'selected':'' }}>في إجازة</option>
                    <option value="inactive" {{ old('status', $staff->status ?? '') == 'inactive' ? 'selected':'' }}>غير نشطة</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">صورة الموظفة</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
            </div>
            <div class="col-md-2">
                <label class="form-label">الترتيب</label>
                <input type="number" name="sort_order" class="form-control" min="0" value="{{ old('sort_order', $staff->sort_order ?? 0) }}">
            </div>
            <div class="col-12" style="border-top:1px solid var(--border);padding-top:1rem;margin-top:.5rem;display:flex;justify-content:space-between;align-items:center;">
                <a href="{{ route('admin.staff.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:.5rem 1.25rem;border-radius:10px;font-weight:700;font-size:.82rem;background:var(--bg-input);color:var(--text-muted);border:1px solid var(--border);text-decoration:none;">
                    <i class="fas fa-arrow-right"></i> رجوع
                </a>
                <button type="submit" class="ops-banner-btn">
                    <i class="fas fa-save"></i>
                    {{ $isEdit ? 'حفظ التعديلات' : 'إضافة الموظفة' }}
                </button>
            </div>
        </div>
    </form>
</div>
