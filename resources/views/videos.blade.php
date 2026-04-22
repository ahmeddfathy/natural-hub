@extends('layouts.app')

@section('title', 'معرض الفيديوهات | Natural Hub')
@section('meta_description', 'معرض فيديوهات Natural Hub — شاهدي جلسات العناية بالشعر والبشرة والرموش بالفيديو.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/videos.css') }}">
@endpush

@section('content')
<!-- ===== HERO ===== -->
    <section class="vd-hero">
        <div class="container">
            <span class="sec-chip">معرض الفيديوهات</span>
            <h1 class="vd-hero-title">شاهدي النتائج <span class="gold">بنفسك</span></h1>
            <p class="vd-hero-sub">فيديوهات حقيقية من جلسات Natural Hub — شعر وبشرة ورموش</p>
        </div>
    </section>

    <!-- ===== VIDEOS BODY ===== -->
    <div class="vd-body">

        <!-- ════════════════════════════
             قسم: علاجات الشعر
        ════════════════════════════ -->
        <div class="vd-section" id="sec-hair">
            <div class="container">
                <div class="vd-section-head">
                    <div class="vd-section-label">
                        <span class="vd-dot hair-dot"></span>
                        <h2>علاجات الشعر</h2>
                    </div>
                    <div class="vd-section-arrows">
                        <button class="vd-arrow vd-arrow-prev" data-track="hair" aria-label="السابق">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="vd-arrow vd-arrow-next" data-track="hair" aria-label="التالي">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="vd-track-wrap">
                <div class="vd-track" id="track-hair">

                    <div class="vd-card">
                        <div class="vd-card-embed">
                            <video controls poster="assets/images/sallon.jpeg">
                                <source src="assets/videos/b&a.mp4" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        </div>
                        <div class="vd-card-info">
                            <span class="vd-card-badge hair-badge"><i class="fas fa-wand-magic-sparkles"></i>
                                الشعر</span>
                            <p>نتائج علاج الشعر بالبروتين</p>
                        </div>
                    </div>

                    <div class="vd-card">
                        <div class="vd-card-embed">
                            <video controls>
                                <source src="assets/videos/IMG_5089.MOV" type="video/quicktime">
                                <source src="assets/videos/IMG_5089.MOV" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        </div>
                        <div class="vd-card-info">
                            <span class="vd-card-badge hair-badge"><i class="fas fa-wand-magic-sparkles"></i>
                                الشعر</span>
                            <p>جلسة فرد وعلاج احترافية</p>
                        </div>
                    </div>

                    <div class="vd-card">
                        <div class="vd-card-embed">
                            <video controls>
                                <source src="assets/videos/IMG_8963.MOV" type="video/quicktime">
                                <source src="assets/videos/IMG_8963.MOV" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        </div>
                        <div class="vd-card-info">
                            <span class="vd-card-badge hair-badge"><i class="fas fa-wand-magic-sparkles"></i>
                                الشعر</span>
                            <p>تغذية الشعر بالأحماض الأمينية</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ════════════════════════════
             قسم: جلسات البشرة
        ════════════════════════════ -->
        <div class="vd-section" id="sec-skin">
            <div class="container">
                <div class="vd-section-head">
                    <div class="vd-section-label">
                        <span class="vd-dot skin-dot"></span>
                        <h2>جلسات البشرة</h2>
                    </div>
                    <div class="vd-section-arrows">
                        <button class="vd-arrow vd-arrow-prev" data-track="skin" aria-label="السابق">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="vd-arrow vd-arrow-next" data-track="skin" aria-label="التالي">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="vd-track-wrap">
                <div class="vd-track" id="track-skin">

                    <div class="vd-card">
                        <div class="vd-card-embed">
                            <video controls poster="assets/images/b&a1.jpeg">
                                <source src="assets/videos/IMG_5046.MOV" type="video/quicktime">
                                <source src="assets/videos/IMG_5046.MOV" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        </div>
                        <div class="vd-card-info">
                            <span class="vd-card-badge skin-badge"><i class="fas fa-sun"></i> البشرة</span>
                            <p>جلسة تنظيف عميق هيدرافيشيل</p>
                        </div>
                    </div>

                    <div class="vd-card">
                        <div class="vd-card-embed">
                            <video controls poster="assets/images/b&a5.jpeg">
                                <source src="assets/videos/IMG_5174.MOV" type="video/quicktime">
                                <source src="assets/videos/IMG_5174.MOV" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        </div>
                        <div class="vd-card-info">
                            <span class="vd-card-badge skin-badge"><i class="fas fa-sun"></i> البشرة</span>
                            <p>نضارة وتفتيح البشرة</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ════════════════════════════
             قسم: تركيب الرموش
        ════════════════════════════ -->
        <div class="vd-section" id="sec-lash">
            <div class="container">
                <div class="vd-section-head">
                    <div class="vd-section-label">
                        <span class="vd-dot lash-dot"></span>
                        <h2>تركيب الرموش</h2>
                    </div>
                    <div class="vd-section-arrows">
                        <button class="vd-arrow vd-arrow-prev" data-track="lash" aria-label="السابق">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="vd-arrow vd-arrow-next" data-track="lash" aria-label="التالي">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="vd-track-wrap">
                <div class="vd-track" id="track-lash">

                    <div class="vd-card">
                        <div class="vd-card-embed">
                            <video controls poster="assets/images/b&a7.jpeg">
                                <source src="assets/videos/IMG_4597.MOV" type="video/quicktime">
                                <source src="assets/videos/IMG_4597.MOV" type="video/mp4">
                                متصفحك لا يدعم تشغيل الفيديو.
                            </video>
                        </div>
                        <div class="vd-card">
                            <div class="vd-card-embed">
                                <video controls poster="assets/images/b&a3.jpeg">
                                    <source src="assets/videos/IMG_4989.MOV" type="video/quicktime">
                                    <source src="assets/videos/IMG_4989.MOV" type="video/mp4">
                                    متصفحك لا يدعم تشغيل الفيديو.
                                </video>
                            </div>
                            <div class="vd-card-info">
                                <span class="vd-card-badge lash-badge"><i class="fas fa-eye"></i> الرموش</span>
                                <p>رفع الحواجب والرموش</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div><!-- /vd-body -->

        <!-- ===== CTA BAND ===== -->
        <div class="cta-band">
            <div class="container cta-band-inner">
                <p>🎬 شاهدتي النتائج؟ حان وقت تجربتها بنفسك!</p>
                <a href="https://wa.me/201001234567" class="btn wa-btn sm" target="_blank">
                    <i class="fab fa-whatsapp"></i> احجزي عبر واتساب
                </a>
            </div>
        </div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/videos.js') }}"></script>
@endpush
