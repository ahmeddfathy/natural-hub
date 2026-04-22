@extends('layouts.app')

@section('title', 'تواصلي معنا | Natural Hub — صالون وسبا المنتجات الطبيعية')
@section('meta_description', 'تواصلي مع Natural Hub — صالون تجميل فاخر في الإسكندرية. احجزي موعدك عبر واتساب.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
@endpush

@section('content')
<!-- ===== MASTER HERO ===== -->
    <section class="master-hero mh-centered" id="contact-hero">
        <div class="mh-bg">
            <div class="mh-overlay"></div>
            <div class="mh-glows"></div>
            <div class="mh-particles">
                <span class="p1"></span><span class="p2"></span><span class="p3"></span><span class="p4"></span>
            </div>
        </div>
        <div class="container mh-inner">
            <div class="mh-content">
                <span class="mh-tag"><i class="fas fa-headset"></i> يسعدنا تواصلكِ</span>
                <h1 class="mh-title">دائماً <br><span class="mh-accent">قريبون منكِ</span></h1>
                <p class="mh-desc">فريقنا جاهز للإجابة على جميع استفساراتكِ ومساعدتكِ في اختيار الجلسات والمنتجات الأنسب لجمالكِ. تواصلوا معنا الآن.</p>
                <div class="mh-btns">
                    <a href="{{ route('services') }}#book-now" class="mh-btn-primary">احجزي موعد</a>
                    <a href="https://wa.me/201001234567" class="mh-btn-outline" target="_blank"><i class="fab fa-whatsapp"></i> واتساب مباشر</a>

                </div>
            </div>
        </div>
    </section>


    <!-- ===== QUICK CONTACT CARDS ===== -->
    <section class="section contact-quick">
        <div class="container">
            <div class="quick-cards-grid">
                <!-- Card 1: WhatsApp -->
                <a href="https://wa.me/201001234567" class="quick-card quick-card-wa" target="_blank" id="waQuickCard">
                    <div class="qc-icon-wrap">
                        <div class="qc-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="qc-ring"></div>
                    </div>
                    <div class="qc-content">
                        <h3>واتساب</h3>
                        <p>احجزي جلستك أو استفسري عن خدماتنا مباشرةً</p>
                        <span class="qc-link">تواصلي الآن <i class="fas fa-arrow-left"></i></span>
                    </div>
                    <div class="qc-badge">الأسرع</div>
                </a>

                <!-- Card 2: Phone -->
                <a href="tel:+201001234567" class="quick-card quick-card-phone" id="phoneQuickCard">
                    <div class="qc-icon-wrap">
                        <div class="qc-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="qc-ring"></div>
                    </div>
                    <div class="qc-content">
                        <h3>اتصلي بينا</h3>
                        <p><span dir="ltr">+20 100 123 4567</span></p>
                        <span class="qc-link">اتصلي الآن <i class="fas fa-arrow-left"></i></span>
                    </div>
                </a>

                <!-- Card 3: Email -->
                <a href="mailto:support@naturalhub.com" class="quick-card quick-card-email" id="emailQuickCard">
                    <div class="qc-icon-wrap">
                        <div class="qc-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="qc-ring"></div>
                    </div>
                    <div class="qc-content">
                        <h3>البريد الإلكتروني</h3>
                        <p>support@naturalhub.com</p>
                        <span class="qc-link">راسلينا <i class="fas fa-arrow-left"></i></span>
                    </div>
                </a>

                <!-- Card 4: Location -->
                <a href="https://maps.google.com/?q=محرم+بك+الإسكندرية" class="quick-card quick-card-location" target="_blank" id="locationQuickCard">
                    <div class="qc-icon-wrap">
                        <div class="qc-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="qc-ring"></div>
                    </div>
                    <div class="qc-content">
                        <h3>موقعنا</h3>
                        <p>محرم بك، الإسكندرية<br>بجوار نادي الصيد</p>
                        <span class="qc-link">افتحي الخريطة <i class="fas fa-arrow-left"></i></span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ===== MAIN CONTACT SECTION ===== -->
    <section class="section contact-main">
        <div class="container">
            <div class="contact-main-grid">

                <!-- RIGHT: Info Panel -->
                <div class="contact-info-side">

                    <!-- Hours Card -->
                    <div class="contact-info-card hours-card">
                        <div class="cic-header">
                            <div class="cic-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h3>ساعات العمل</h3>
                        </div>
                        <div class="hours-list">
                            <div class="hour-row">
                                <span class="day-name">السبت — الخميس</span>
                                <span class="hour-time">10 ص — 10 م</span>
                            </div>
                            <div class="hour-row highlight">
                                <span class="day-name">الجمعة</span>
                                <span class="hour-time">1 م — 10 م</span>
                            </div>
                        </div>
                        <div class="open-now-badge" id="openNowBadge">
                            <span class="open-dot"></span>
                            <span id="openNowText">مفتوح الآن</span>
                        </div>
                    </div>

                    <!-- Social Media Card -->
                    <div class="contact-info-card social-card">
                        <div class="cic-header">
                            <div class="cic-icon" style="background: linear-gradient(135deg, #ff7a95, #f74d6c);">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h3>تابعينا على</h3>
                        </div>
                        <div class="social-links-grid">
                            <a href="#" class="social-link-card sl-insta" id="instaLink" target="_blank">
                                <div class="sl-icon">
                                    <i class="fab fa-instagram"></i>
                                </div>
                                <div class="sl-info">
                                    <span class="sl-name">Instagram</span>
                                    <span class="sl-handle">@naturalhub</span>
                                </div>
                                <i class="fas fa-external-link-alt sl-ext"></i>
                            </a>
                            <a href="#" class="social-link-card sl-fb" id="fbLink" target="_blank">
                                <div class="sl-icon">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div class="sl-info">
                                    <span class="sl-name">Facebook</span>
                                    <span class="sl-handle">NaturalHub</span>
                                </div>
                                <i class="fas fa-external-link-alt sl-ext"></i>
                            </a>
                            <a href="#" class="social-link-card sl-tiktok" id="tiktokLink" target="_blank">
                                <div class="sl-icon">
                                    <i class="fab fa-tiktok"></i>
                                </div>
                                <div class="sl-info">
                                    <span class="sl-name">TikTok</span>
                                    <span class="sl-handle">@naturalhub</span>
                                </div>
                                <i class="fas fa-external-link-alt sl-ext"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Booking Tip -->
                    <div class="booking-tip-card">
                        <i class="fas fa-lightbulb tip-icon"></i>
                        <div>
                            <strong>نصيحة للحجز السريع</strong>
                            <p>للحصول على موعدك بشكل أسرع، تواصلي معنا مباشرة عبر واتساب أو اتصلي بنا في أوقات الذروة (10ص — 2م)</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ===== MAP SECTION ===== -->
    <section class="contact-map-section">
        <div class="container">
            <div class="sec-head" style="padding-bottom: 40px;">
                <span class="sec-chip">موقعنا</span>
                <h2 class="sec-title">هتلاقينا في <span class="gold">محرم بك</span></h2>
                <p class="sec-sub">إسكندرية — بجوار نادي الصيد</p>
            </div>
        </div>
        <div class="map-wrapper">
            <div class="map-overlay-card">
                <div class="map-card-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="map-card-info">
                    <strong>Natural Hub Spa & Salon</strong>
                    <span>محرم بك، الإسكندرية، مصر</span>
                    <span>بجوار نادي الصيد</span>
                </div>
                <a href="https://maps.google.com/?q=محرم+بك+الإسكندرية" target="_blank" class="map-directions-btn" id="directionsBtn">
                    <i class="fas fa-route"></i> خريطة جوجل
                </a>
            </div>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3412.0!2d29.9!3d31.19!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f5c5!2sMoharam+Bek%2C+Alexandria!5e0!3m2!1sar!2seg!4v1"
                width="100%" height="480" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade" title="خريطة Natural Hub">
            </iframe>
        </div>
    </section>

    <!-- ===== FAQ SECTION ===== -->
    <section class="section contact-faq">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">الأسئلة الشائعة</span>
                <h2 class="sec-title">إجابات على <span class="gold">أسئلتك</span></h2>
                <p class="sec-sub">كل اللي بتسأليه عنه — هنا</p>
            </div>
            <div class="faq-list" id="faqList">

                <div class="faq-item" id="faq1">
                    <button class="faq-btn" aria-expanded="false" aria-controls="faqAns1">
                        <span>كيف أحجز موعد في Natural Hub؟</span>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-ans" id="faqAns1" role="region">
                        <p>أسهل طريقة للحجز هي عبر واتساب مباشرة. يمكنك أيضاً الاتصال بنا أو ملء نموذج الحجز في هذه الصفحة وسنتواصل معك فوراً للتأكيد.</p>
                    </div>
                </div>

                <div class="faq-item" id="faq2">
                    <button class="faq-btn" aria-expanded="false" aria-controls="faqAns2">
                        <span>هل أحتاج إلى دفع مقدم لتأكيد الحجز؟</span>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-ans" id="faqAns2" role="region">
                        <p>لبعض الخدمات المميزة كباقة العروسة، يُطلب دفع مبلغ مقدم بسيط لتأكيد الحجز. معظم الجلسات العادية لا تحتاج دفع مسبق.</p>
                    </div>
                </div>

                <div class="faq-item" id="faq3">
                    <button class="faq-btn" aria-expanded="false" aria-controls="faqAns3">
                        <span>كم تستغرق جلسة العناية بالشعر؟</span>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-ans" id="faqAns3" role="region">
                        <p>تتراوح مدة جلسات الشعر (بروتين / كيراتين) بين ساعتين و4 ساعات حسب طول الشعر والخدمة المطلوبة. جلسات البشرة تستغرق من 45 دقيقة إلى ساعة ونصف.</p>
                    </div>
                </div>

                <div class="faq-item" id="faq4">
                    <button class="faq-btn" aria-expanded="false" aria-controls="faqAns4">
                        <span>هل المنتجات المستخدمة آمنة؟</span>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-ans" id="faqAns4" role="region">
                        <p>نعم بالتأكيد! نستخدم فقط منتجات طبية مرخصة وبراندات عالمية معتمدة. صحتك أولويتنا القصوى وكل أدواتنا معقمة بأعلى المعايير.</p>
                    </div>
                </div>

                <div class="faq-item" id="faq5">
                    <button class="faq-btn" aria-expanded="false" aria-controls="faqAns5">
                        <span>هل يمكن إلغاء أو تغيير موعد الحجز؟</span>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-ans" id="faqAns5" role="region">
                        <p>يمكنك تعديل أو إلغاء موعدك بسهولة عبر التواصل معنا على واتساب قبل 24 ساعة على الأقل من الموعد المحدد.</p>
                    </div>
                </div>

                <div class="faq-item" id="faq6">
                    <button class="faq-btn" aria-expanded="false" aria-controls="faqAns6">
                        <span>ما هي طرق الدفع المتاحة؟</span>
                        <i class="fas fa-plus faq-icon"></i>
                    </button>
                    <div class="faq-ans" id="faqAns6" role="region">
                        <p>نقبل الدفع نقداً أو عبر تحويل بنكي. يتم تحديد طريقة الدفع عند التواصل لتأكيد الحجز.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== FINAL CTA ===== -->
    <section class="contact-final-cta">
        <div class="cfc-bg"></div>
        <div class="container cfc-inner">
            <div class="cfc-floats">
                <div class="cfc-float-item cfi1"><i class="fas fa-spa"></i></div>
                <div class="cfc-float-item cfi2"><i class="fas fa-star"></i></div>
                <div class="cfc-float-item cfi3"><i class="fas fa-heart"></i></div>
                <div class="cfc-float-item cfi4"><i class="fas fa-crown"></i></div>
            </div>
            <h2>جمالك مش ممكن يستنى <span>✨</span></h2>
            <p>خطوة واحدة تفصلك عن تجربة عناية استثنائية. تواصلي معنا دلوقتي!</p>
            <div class="cfc-actions">
                <a href="https://wa.me/201001234567" class="btn wa-btn" target="_blank" id="ctaWaBtn">
                    <i class="fab fa-whatsapp"></i> احجزي عبر واتساب
                </a>
                <a href="tel:+201001234567" class="btn contact-ghost-btn" id="ctaCallBtn">
                    <i class="fas fa-phone"></i> اتصلي بينا
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/contact.js') }}"></script>
@endpush
