@extends('admin.layout')
@section('title', isset($staff) ? 'تعديل موظفة' : 'إضافة موظفة')
@section('page-title', isset($staff) ? 'تعديل: ' . $staff->name : 'إضافة موظفة جديدة')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.staff.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-right me-1"></i> العودة
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif

        <form method="POST"
              action="{{ isset($staff) ? route('admin.staff.update', $staff) : route('admin.staff.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($staff)) @method('PUT') @endif

            <div class="row g-3">
                @if(isset($staff) && $staff->avatar)
                <div class="col-12">
                    <img src="{{ $staff->avatar_url }}" alt="{{ $staff->name }}"
                         class="rounded-circle mb-2" width="80" height="80" style="object-fit:cover">
                </div>
                @endif

                <div class="col-md-6">
                    <label class="form-label">الاسم <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $staff->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">الفرع <span class="text-danger">*</span></label>
                    <select name="branch_id" class="form-select" required>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}"
                                    {{ old('branch_id', $staff->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">التخصص</label>
                    <input type="text" name="specialty" class="form-control"
                           value="{{ old('specialty', $staff->specialty ?? '') }}"
                           placeholder="شعر / بشرة / رموش / الكل">
                </div>
                <div class="col-md-4">
                    <label class="form-label">رقم الموبايل</label>
                    <input type="text" name="phone" class="form-control"
                           value="{{ old('phone', $staff->phone ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">الحالة <span class="text-danger">*</span></label>
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
                    <input type="number" name="sort_order" class="form-control" min="0"
                           value="{{ old('sort_order', $staff->sort_order ?? 0) }}">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        {{ isset($staff) ? 'حفظ التعديلات' : 'إضافة الموظفة' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
