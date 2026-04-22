@if($errors->any())
    <div class="alert alert-danger d-flex align-items-start gap-3 mb-4" role="alert">
        <i class="fas fa-exclamation-triangle mt-1"></i>
        <div>
            <strong>يوجد بعض الأخطاء في البيانات المدخلة.</strong>
            <ul class="mb-0 mt-2 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
