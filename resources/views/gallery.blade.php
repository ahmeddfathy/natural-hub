@extends('layouts.app')

@section('title', 'المعرض | Natural Hub')
@section('meta_description', 'معرض Natural Hub — شاهدي أحدث نتائج جلسات العناية بالشعر والبشرة والرموش.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/gallery.css') }}">
@endpush

@section('content')
<!-- ===== HERO ===== -->
    <section class="gl-hero">
        <div class="container">
            <span class="sec-chip">معرض الأعمال</span>
            <h1 class="gl-hero-title">نتائجنا تتكلم <span class="gold">عن نفسها</span></h1>
            <p class="gl-hero-sub">صور حقيقية من داخل Natural Hub — شاهدي تحولات عميلاتنا</p>
        </div>
    </section>

    <!-- ===== GALLERY BODY ===== -->
    <div class="gl-body">

        @if($images->isNotEmpty())
            @foreach($images->groupBy('category_type') as $catKey => $catImages)
            @php
                $catLabel = match($catKey) {
                    'Hair'   => 'علاجات الشعر',
                    'Skin'   => 'جلسات البشرة',
                    'Lashes' => 'تركيب الرموش',
                    default  => $catKey
                };
                $dotClass = match($catKey) {
                    'Hair'   => 'hair-dot',
                    'Skin'   => 'skin-dot',
                    'Lashes' => 'lash-dot',
                    default  => 'hair-dot'
                };
                $trackId = Str::slug($catKey);
            @endphp
            <div class="gl-section" id="sec-{{ $trackId }}">
                <div class="container">
                    <div class="gl-section-head">
                        <div class="gl-section-label">
                            <span class="gl-dot {{ $dotClass }}"></span>
                            <h2>{{ $catLabel }}</h2>
                        </div>
                        <div class="gl-section-arrows">
                            <button class="gl-arrow gl-arrow-prev" data-track="{{ $trackId }}"><i class="fas fa-chevron-right"></i></button>
                            <button class="gl-arrow gl-arrow-next" data-track="{{ $trackId }}"><i class="fas fa-chevron-left"></i></button>
                        </div>
                    </div>
                </div>
                <div class="gl-track-wrap">
                    <div class="gl-track" id="track-{{ $trackId }}">
                        @foreach($catImages as $img)
                        <div class="gl-card"
                             data-img="{{ asset('storage/'.$img->image_path) }}"
                             data-title="{{ $img->title }}"
                             data-desc="{{ $img->description }}">
                            <div class="gl-card-img">
                                <img src="{{ asset('storage/'.$img->image_path) }}" alt="{{ $img->title }}" loading="lazy">
                            </div>
                            <div class="gl-card-info"><span>{{ $img->title }}</span></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        @else
        {{-- Fallback لو الـ DB فاضية --}}
        <div class="container" style="text-align:center;padding:80px 0;">
            <p style="opacity:.5;font-size:1.2rem;">المعرض قيد التحديث — تابعينا قريباً</p>
        </div>
        @endif


    </div>
<!-- ===== LIGHTBOX ===== -->
    <div class="gl-lightbox" id="glLightbox" role="dialog" aria-modal="true">
        <button class="gl-lb-close" id="glLbClose" aria-label="إغلاق"><i class="fas fa-times"></i></button>
        <button class="gl-lb-prev"  id="glLbPrev"  aria-label="السابق"><i class="fas fa-chevron-right"></i></button>
        <button class="gl-lb-next"  id="glLbNext"  aria-label="التالي"><i class="fas fa-chevron-left"></i></button>
        <div class="gl-lb-main">
            <div class="gl-lb-img-wrap">
                <img src="" alt="" id="glLbImg">
                <div class="gl-lb-loader"><i class="fas fa-spinner fa-spin"></i></div>
            </div>
            <div class="gl-lb-info">
                <h3 id="glLbTitle"></h3>
                <p  id="glLbDesc"></p>
                <a href="index.html#booking" class="btn pink-btn sm">
                    <i class="fas fa-calendar-check"></i> احجزي الآن
                </a>
            </div>
        </div>
    </div>
    <div class="gl-lb-backdrop" id="glLbBackdrop"></div>

    <!-- ===== CTA ===== -->
    <div class="cta-band">
        <div class="container cta-band-inner">
            <p>🌿 شاهدتي النتائج؟ حان وقتك!</p>
            <a href="https://wa.me/201001234567" class="btn wa-btn sm" target="_blank">
                <i class="fab fa-whatsapp"></i> احجزي الآن
            </a>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/gallery.js') }}"></script>
@endpush
