@if($errors->any())
    <div style="display:flex;align-items:flex-start;gap:.75rem;padding:1rem 1.25rem;border-radius:14px;margin-bottom:1.5rem;background:rgba(220,38,38,.06);color:#dc2626;border:1px solid rgba(220,38,38,.12);font-size:.88rem;">
        <i class="fas fa-exclamation-triangle" style="margin-top:2px;"></i>
        <div>
            <strong>يوجد بعض الأخطاء في البيانات المدخلة.</strong>
            <ul style="margin:8px 0 0;padding-right:1.25rem;list-style:disc;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
