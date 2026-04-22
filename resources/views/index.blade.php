@extends('layouts.app')

@section('title', 'Natural Hub | صالون العناية الفاخرة بالشعر والبشرة والرموش')
@section('meta_description', 'Natural Hub - صالون تجميل فاخر متخصص في العناية بالشعر والبشرة والرموش. احجزي جلستك الآن واستمتعي بتجربة عناية استثنائية.')

@push('styles')
@endpush

@section('content')

    <!-- ===== MASTER HERO ===== -->
    <section class="master-hero mh-centered" id="hero">
        <div class="mh-bg">
            <div class="mh-overlay"></div>
            <div class="mh-glows"></div>
            <div class="mh-particles">
                <span class="p1"></span><span class="p2"></span><span class="p3"></span><span class="p4"></span>
            </div>
        </div>
        <div class="container mh-inner">
            <div class="mh-content">
                <span class="mh-tag"><i class="fas fa-sparkles"></i> مرحباً بكِ في Natural Hub</span>
                <h1 class="mh-title">جمالكِ يستحق <br><span class="mh-accent">الأفضل دائماً</span></h1>
                <p class="mh-desc">نحن لا نقدم مجرد خدمات، بل نصنع تجربة فريدة للعناية بجمالكِ الطبيعي بأحدث التقنيات
                    العالمية وأيدي خبراء متخصصين.</p>
                <div class="mh-btns">
                    <a href="services.html" class="mh-btn-primary">استكشفي خدماتنا</a>
                    <a href="https://wa.me/201001234567" class="mh-btn-outline" target="_blank"><i
                            class="fab fa-whatsapp"></i> احجزي جلستكِ</a>
                </div>
            </div>
    </section>

    <!-- ===== WHY NATURAL HUB ===== -->
    <section class="section why" id="why">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">لماذا Natural Hub</span>
                <h2 class="sec-title">لأنك تستحقي <span class="gold">الأفضل</span></h2>
            </div>
        </div>

        <div class="swipe-container-fluid">
            <button class="swipe-arrow prev" aria-label="السابق"><i class="fas fa-chevron-right"></i></button>
            <div class="swipe-track why-track" id="whyTrack">
                <div class="why-card">
                    <div class="why-img">
                        <img src="assets/images/b&a1.jpeg" alt="جلسات علاجية" loading="lazy">
                    </div>
                    <h3>جلسات علاجية حقيقية</h3>
                    <p>مش مجرد تجميل سطحي… بنعالج المشكلة من جذورها ونحافظ على النتيجة.</p>
                </div>
                <div class="why-card">
                    <div class="why-img">
                        <img src="assets/images/b&a2.jpeg" alt="عناية مخصصة" loading="lazy">
                    </div>
                    <h3>عناية مخصصة ليكي</h3>
                    <p>كل بشرة وشعر مختلف. عشان كده بنصمم خطة عناية شخصية حسب احتياجك.</p>
                </div>
                <div class="why-card">
                    <div class="why-img">
                        <img src="assets/images/2jpeg.jpeg" alt="منتجات فاخرة" loading="lazy">
                    </div>
                    <h3>منتجات عالمية فاخرة</h3>
                    <p>بنستخدم أفضل البراندات الطبية المعتمدة. جمالك ما ينفعش نجرب فيه.</p>
                </div>
                <div class="why-card">
                    <div class="why-img">
                        <img src="assets/images/sallon.jpeg" alt="نظافة وأمان" loading="lazy">
                    </div>
                    <h3>نظافة وأمان كامل</h3>
                    <p>أعلى معايير التعقيم في كل ركن. أدوات معقمة وبيئة صحية لراحتك.</p>
                </div>
                <div class="why-card">
                    <div class="why-img">
                        <img src="assets/images/1.jpeg" alt="نتائج ملموسة" loading="lazy">
                    </div>
                    <h3>نتائج ملموسة</h3>
                    <p>الفرق هتحسي بيه من أول جلسة. نتائج حقيقية ومستمرة مش مؤقتة.</p>
                </div>
            </div>
            <button class="swipe-arrow next" aria-label="التالي"><i class="fas fa-chevron-left"></i></button>
        </div>
    </section>



    <!-- ===== CTA BAND ===== -->
    <div class="cta-band">
        <div class="container cta-band-inner">
            <p>جاهزة تبدأي رحلة عنايتك؟</p>
            <a href="https://wa.me/201001234567" class="btn wa-btn sm" target="_blank"><i class="fab fa-whatsapp"></i>
                احجزي عبر واتساب</a>
        </div>
    </div>

    <!-- ===== SERVICES ===== -->
    <section class="section services" id="services">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">خدماتنا</span>
                <h2 class="sec-title">عناية متكاملة لكل تفاصيل <span class="gold">جمالك</span></h2>
                <p class="sec-sub">الشعر الكثيف أو الطويل جداً بيزيد ٥٠٠ ج.م على سعر الجلسة ✨</p>
                <p class="sec-sub">اسحبي لاستكشاف خدماتنا ←</p>
            </div>
        </div>
        <div class="swipe-track" id="servicesTrack">
            <!-- Card 1: Hair -->
            <div class="srv-card">
                <div class="srv-img">
                    <img src="assets/images/1.jpeg" alt="علاجات الشعر" loading="lazy">
                    <span class="srv-badge">الأكثر طلباً</span>
                </div>
                <div class="srv-body">
                    <div class="srv-icon"><i class="fas fa-wand-magic-sparkles"></i></div>
                    <h3>علاجات الشعر</h3>
                    <p>شعر صحي، لامع، وقوي من الجذور للأطراف مع بروتين وكيراتين بأفضل الخامات.</p>
                    <a href="#booking" class="btn gold-btn sm"><i class="fas fa-calendar-check"></i> احجزي جلستك</a>
                </div>
            </div>
            <!-- Card 2: Skin -->
            <div class="srv-card featured-card">
                <div class="srv-img">
                    <img src="assets/images/b&a5.jpeg" alt="جلسات البشرة" loading="lazy">
                    <span class="srv-badge gold-badge">Premium</span>
                </div>
                <div class="srv-body">
                    <div class="srv-icon"><i class="fas fa-sun"></i></div>
                    <h3>جلسات العناية بالبشرة</h3>
                    <p>تنظيف عميق، تفتيح، نضارة، وعلاج مشاكل البشرة بتقنيات متقدمة ومنتجات طبية.</p>
                    <a href="#booking" class="btn gold-btn sm"><i class="fas fa-calendar-check"></i> احجزي جلستك</a>
                </div>
            </div>
            <!-- Card 3: Lashes -->
            <div class="srv-card">
                <div class="srv-img">
                    <img src="assets/images/b&a4.jpeg" alt="تركيب الرموش" loading="lazy">
                    <span class="srv-badge">مميز</span>
                </div>
                <div class="srv-body">
                    <div class="srv-icon"><i class="fas fa-eye"></i></div>
                    <h3>تركيب الرموش</h3>
                    <p>رموش طبيعية وكثيفة تبرز جمال عينيكي. تركيب احترافي بخامات فاخرة ومريحة.</p>
                    <a href="#booking" class="btn gold-btn sm"><i class="fas fa-calendar-check"></i> احجزي جلستك</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== RESULTS / TRANSFORMATIONS ===== -->
    <section class="section results" id="results">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">النتائج الحقيقية</span>
                <h2 class="sec-title">تحولات عميلاتنا <span class="gold">تتكلم</span></h2>
                <p class="sec-sub">نتائج فعلية من جلسات العناية في Natural Hub</p>
            </div>
            <div class="ba-grid">
                <!-- Before/After 1 -->
                <div class="ba-card">
                    <div class="ba-images single-img">
                        <img src="assets/images/b&a1.jpeg" alt="Hydrafacial Deep Cleansing" loading="lazy">
                    </div>
                    <div class="ba-info">
                        <h4>Hydrafacial Deep Cleansing</h4>
                        <p>تنظيف عميق ونضارة فورية للبشرة</p>
                    </div>
                </div>
                <!-- Before/After 2 -->
                <div class="ba-card">
                    <div class="ba-images single-img">
                        <img src="assets/images/b&a7.jpeg" alt="Lash Extensions" loading="lazy">
                    </div>
                    <div class="ba-info">
                        <h4>Lash Extensions</h4>
                        <p>تركيب رموش هير باي هير (الريفيل خلال ٣ أيام مجاناً)</p>
                    </div>
                </div>
                <!-- Before/After 3 -->
                <div class="ba-card">
                    <div class="ba-images single-img">
                        <img src="assets/images/b&a3.jpeg" alt="Brow Lamination" loading="lazy">
                    </div>
                    <div class="ba-info">
                        <h4>Brow Lamination & Lash Lifting</h4>
                        <p>رفع وتنسيق الحواجب والرموش بنتائج مبهرة</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA BAND 2 ===== -->
    <div class="cta-band alt">
        <div class="container cta-band-inner">
            <p>ابدأي التغيير دلوقتي ✨</p>
            <a href="https://wa.me/201001234567" class="btn wa-btn sm" target="_blank"><i class="fab fa-whatsapp"></i>
                تواصلي معانا</a>
        </div>
    </div>

    <!-- ===== GALLERY ===== -->
    <section class="section gallery" id="gallery">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">من داخل الصالون</span>
                <h2 class="sec-title">مكان يليق <span class="gold">بجمالك</span></h2>
                <p class="sec-sub">اسحبي لمشاهدة المزيد ←</p>
            </div>
        </div>
        <div class="swipe-track gallery-track" id="galleryTrack">
            <div class="gal-card">
                <img src="assets/images/sallon.jpeg" alt="أجواء الصالون" loading="lazy">
                <span class="gal-caption">أجواء فاخرة ومريحة</span>
            </div>
            <div class="gal-card">
                <img src="assets/images/1.jpeg" alt="نتائج الشعر" loading="lazy">
                <span class="gal-caption">نتائج مبهرة للشعر</span>
            </div>
            <div class="gal-card">
                <img src="assets/images/2jpeg.jpeg" alt="منتجاتنا" loading="lazy">
                <span class="gal-caption">أفضل المنتجات العالمية</span>
            </div>
            <div class="gal-card">
                <img src="assets/images/b&a2.jpeg" alt="عناية بالبشرة" loading="lazy">
                <span class="gal-caption">جلسات نضارة وتفتيح</span>
            </div>
            <div class="gal-card">
                <img src="assets/images/b&a4.jpeg" alt="رموش فاخرة" loading="lazy">
                <span class="gal-caption">رموش طبيعية وكثيفة</span>
            </div>
            <div class="gal-card">
                <img src="assets/images/b&a6.jpeg" alt="نتائج حقيقية" loading="lazy">
                <span class="gal-caption">نتائج تتحدث عن نفسها</span>
            </div>
        </div>
    </section>

    <!-- ===== VIDEO GALLERY ===== -->
    <section class="section video-gallery" id="videos">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">شاهدي النتائج</span>
                <h2 class="sec-title">فيديوهات من <span class="gold">جلساتنا</span></h2>
                <p class="sec-sub">اسحبي لمشاهدة المزيد ←</p>
            </div>
        </div>
        <div class="swipe-track video-track" id="videoTrack">
            <div class="video-card">
                <div class="video-wrapper">
                    <video controls poster="assets/images/sallon.jpeg">
                        <source src="assets/videos/b&a.mp4" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                </div>
                <span class="video-caption">نتائج علاج الشعر والبشرة</span>
            </div>
            <div class="video-card">
                <div class="video-wrapper">
                    <video controls poster="assets/images/2jpeg.jpeg">
                        <source src="assets/videos/products.mp4" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                </div>
                <span class="video-caption">منتجات العناية بالأفتركير</span>
            </div>
            <div class="video-card">
                <div class="video-wrapper">
                    <video controls>
                        <source src="assets/videos/IMG_4597.MOV" type="video/quicktime">
                        <source src="assets/videos/IMG_4597.MOV" type="video/mp4">
                        متصفحك لا يدعم تشغيل الفيديو.
                    </video>
                </div>
                <span class="video-caption">من داخل صالون Natural Hub</span>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="section reviews" id="reviews">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">آراء عميلاتنا</span>
                <h2 class="sec-title">كلامهم هو أحلى <span class="gold">شهادة</span></h2>
            </div>
            <div class="rev-grid">
                <div class="rev-card">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"أول مرة أحس إن حد فعلاً فاهم شعري ومحتاج إيه. النتيجة كانت مذهلة وشعري بقى صحي
                        ولامع. شكراً Natural Hub!"</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a3.jpeg" alt="سارة أحمد" loading="lazy">
                        <div>
                            <strong>سارة أحمد</strong>
                            <span>علاج بروتين للشعر</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
                <div class="rev-card">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"بشرتي اتغيرت ١٨٠ درجة بعد 3 جلسات! المكان نضيف جداً والبنات محترفات ولطيفات.
                        حاسة إني لقيت مكاني أخيراً."</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a5.jpeg" alt="نورهان محمد" loading="lazy">
                        <div>
                            <strong>نورهان محمد</strong>
                            <span>جلسات تنظيف ونضارة</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
                <div class="rev-card">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"الرموش طبيعية جداً مش حاسة بيها خالص! كل الناس بتسألني عليها. أحسن مكان جربته
                        للرموش بأمانة."</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a7.jpeg" alt="مريم خالد" loading="lazy">
                        <div>
                            <strong>مريم خالد</strong>
                            <span>تركيب رموش</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
                <div class="rev-card">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"تجربة الأوكسجينو كانت خيالية! بشرتي بقت منورة وناعمة جداً والمسام صغرت بشكل
                        ملحوظ. فعلاً المكان الأفضل في الإسكندرية."</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a8.jpeg" alt="هنا علي" loading="lazy">
                        <div>
                            <strong>هنا علي</strong>
                            <span>جلسة أوكسجينو للبشرة</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCTS ===== -->
    <section class="section products-section" id="products">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip" style="background: rgba(247, 77, 108, 0.1); color:#f74d6c;">منتجاتنا</span>
                <h2 class="sec-title">أفضل منتجات <span style="color:#f74d6c">العناية</span></h2>
                <p class="sec-sub">اختاري من مجموعة مختارة من أفضل المنتجات الطبيعية لبشرتك وشعرك.</p>
            </div>

            <div class="prod-grid">
                <!-- Product 1: Aftercare Bundle -->
                <div class="prod-card">
                    <div class="prod-img">
                        <span class="prod-badge pink-badge">بينك</span>
                        <img src="assets/images/2jpeg.jpeg" alt="Aftercare Bundle Pink">
                        <div class="prod-overlay">
                            <button class="add-cart-btn"><i class="fas fa-shopping-cart"></i> اطلبي الآن</button>
                        </div>
                    </div>
                    <div class="prod-info">
                        <h3>مجموعة العناية (Pink)</h3>
                        <p>للشعر العادي والدهني (١٠٠٠ مل)</p>
                        <div class="prod-price">١٠٠٠ ج.م</div>
                    </div>
                </div>
                <!-- Product 2: Aftercare Bundle -->
                <div class="prod-card">
                    <div class="prod-img">
                        <span class="prod-badge green-badge">أخضر</span>
                        <img src="assets/images/2jpeg.jpeg" alt="Aftercare Bundle Green">
                        <div class="prod-overlay">
                            <button class="add-cart-btn"><i class="fas fa-shopping-cart"></i> اطلبي الآن</button>
                        </div>
                    </div>
                    <div class="prod-info">
                        <h3>مجموعة العناية (Green)</h3>
                        <p>للشعر المصبوغ (٥٠٠ مل)</p>
                        <div class="prod-price">٨٠٠ ج.م</div>
                    </div>
                </div>
                <!-- Product 3: Individual Item -->
                <div class="prod-card">
                    <div class="prod-img">
                        <img src="assets/images/2jpeg.jpeg" alt="Serum">
                        <div class="prod-overlay">
                            <button class="add-cart-btn"><i class="fas fa-shopping-cart"></i> اطلبي الآن</button>
                        </div>
                    </div>
                    <div class="prod-info">
                        <h3>سيروم العناية (١٠٠ مل)</h3>
                        <p>مناسب لجميع أنواع الشعر</p>
                        <div class="prod-price">٣٥٠ ج.م</div>
                    </div>
                </div>
                <!-- Product 4: Individual Item -->
                <div class="prod-card">
                    <div class="prod-img">
                        <img src="assets/images/2jpeg.jpeg" alt="Hair Mask">
                        <div class="prod-overlay">
                            <button class="add-cart-btn"><i class="fas fa-shopping-cart"></i> اطلبي الآن</button>
                        </div>
                    </div>
                    <div class="prod-info">
                        <h3>حمام كريم (٥٠٠ مل)</h3>
                        <p>ترطيب عميق وإصلاح فوري</p>
                        <div class="prod-price">٣٥٠ ج.م</div>
                    </div>
                </div>
            </div>

            <div style="text-align:center; margin-top: 40px;">
                <a href="#products" class="btn pink-btn outline-pink">عرض كل المنتجات</a>
            </div>
        </div>
    </section>

    <!-- ===== AWESOME CTA ===== -->
    <section class="awesome-cta">
        <div class="container cta-container">
            <div class="cta-text-side">
                <h2>احجزي الآن <span style="color:#f74d6c">جمالك مش ممكن يستنى ✨</span></h2>
                <p>خطوة واحدة بس تفصلك عن تجربة عناية مختلفة تماماً. تواصلي معانا دلوقتي واحجزي جلستك.</p>
                <div class="cta-info-list">
                    <div class="cta-info-item"><i class="fas fa-map-marker-alt"></i> الفرع محرم بك، الإسكندرية</div>
                    <div class="cta-info-item"><i class="fas fa-clock"></i> مواعيد العمل يومياً من 10 صباحاً حتى 10
                        مساءً</div>
                    <div class="cta-info-item"><i class="fas fa-phone"></i> <span dir="ltr">+20 100 123 4567</span>
                    </div>
                </div>
                <div class="cta-actions">
                    <a href="https://wa.me/201001234567" class="btn wa-btn" target="_blank"><i
                            class="fab fa-whatsapp"></i> احجزي عبر واتساب</a>
                    <a href="tel:+201001234567" class="btn wa-ghost-btn"><i class="fas fa-phone"></i> اتصلي بينا</a>
                </div>
            </div>
            <div class="cta-img-side">
                <img src="{{ asset('assets/images/logo/cta.jpeg') }}" alt="Natural Hub Spa">
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/script.js') }}"></script>
@endpush