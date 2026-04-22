@extends('layouts.app')

@section('title', 'من نحن | Natural Hub — صالون وسبا المنتجات الطبيعية')
@section('meta_description', 'تعرفي على Natural Hub — صالون تجميل فاخر في الإسكندرية. قصتنا، فريقنا، وقيمنا في تقديم عناية استثنائية لكل سيدة.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/about.css') }}">
@endpush

@section('content')
<!-- ===== MASTER HERO ===== -->
    <section class="master-hero mh-centered" id="about-hero">
        <div class="mh-bg">
            <div class="mh-overlay"></div>
            <div class="mh-glows"></div>
            <div class="mh-particles">
                <span class="p1"></span><span class="p2"></span><span class="p3"></span><span class="p4"></span>
            </div>
        </div>
        <div class="container mh-inner">
            <div class="mh-content">
                <span class="mh-tag"><i class="fas fa-heart"></i> قصتنا وشغفنا</span>
                <h1 class="mh-title">أكثر من مجرد <br><span class="mh-accent">مركز تجميل</span></h1>
                <p class="mh-desc">نحن في Natural Hub نؤمن أن الجمال الحقيقي يبدأ بالعناية الذاتية. رحلتنا بدأت بشغف لتقديم أفضل الحلول الطبيعية والآمنة لكل امرأة تبحث عن التميز.</p>
                <div class="mh-btns">
                    <a href="#story" class="mh-btn-primary">اكتشفي قصتنا</a>
                    <a href="contact.html" class="mh-btn-outline">تواصلوا معنا</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STORY SECTION ===== -->
    <section class="section about-story">
        <div class="container about-story-grid">
            <div class="story-text">
                <span class="sec-chip">قصتنا</span>
                <h2 class="sec-title">بدأنا بحلم بسيط… <span class="gold">إنك تحسي بالفرق</span></h2>
                <p class="story-lead">Natural Hub هو ثمرة شغف خالص لتقديم تجربة جمال متكاملة. بدأنا رحلتنا بفرعنا الجديد في محرم بك بالإسكندرية، بإيمان إن كل سيدة تستحق عناية تليق بجمالها الطبيعي.</p>
                <p>من أول يوم وإحنا عارفين إن الحلول الجاهزة مش هي الحل. عشان كدة بنبني لكل عميلة خطة عناية مخصصة، بنستخدم فيها أجود المنتجات العالمية وبأحدث التقنيات الطبية لضمان نتائج مبهرة وصحية.</p>
                <p>مكاننا الجديد في محرم بك (بجوار نادي الصيد) مجهز بالكامل ليكون ملاذك الهادئ، حيث يلتقي الاحتراف مع الراحة التامة.</p>
                <div class="story-pillars">
                    <div class="story-pillar">
                        <i class="fas fa-heart"></i>
                        <div>
                            <strong>بنعامل كل عميلة</strong>
                            <span>كأنها الأهم عندنا</span>
                        </div>
                    </div>
                    <div class="story-pillar">
                        <i class="fas fa-leaf"></i>
                        <div>
                            <strong>منتجات طبيعية وآمنة</strong>
                            <span>على بشرتك وشعرك</span>
                        </div>
                    </div>
                </div>
                <a href="index.html#booking" class="btn pink-btn" style="margin-top:20px;">احجزي جلستك الآن</a>
            </div>
            <div class="story-img-wrap">
                <div class="story-img-main">
                    <img src="assets/images/sallon.jpeg" alt="Natural Hub Salon Interior">
                </div>
                <div class="story-img-accent">
                    <img src="assets/images/1.jpeg" alt="Hair Treatment">
                </div>
                <div class="story-badge-float">
                    <i class="fas fa-spa"></i>
                    <span>صالون موثوق</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== VALUES SECTION ===== -->
    <section class="section about-values">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">قيمنا</span>
                <h2 class="sec-title">اللي بيفرقنا عن <span class="gold">غيرنا</span></h2>
                <p class="sec-sub">مش كلام فاضي… ده اللي بنطبقه كل يوم مع كل عميلة</p>
            </div>
            <div class="values-grid">
                <div class="value-card reveal">
                    <div class="value-icon-wrap">
                        <div class="value-icon">
                            <i class="fas fa-shield-heart"></i>
                        </div>
                        <div class="value-icon-ring"></div>
                    </div>
                    <h3>الأمان أولاً</h3>
                    <p>كل الأدوات معقمة، كل المنتجات مرخصة، وكل الإجراءات آمنة تماماً. صحتك مش أمانة نقصر فيها.</p>
                </div>
                <div class="value-card reveal" data-d="100">
                    <div class="value-icon-wrap">
                        <div class="value-icon" style="background: linear-gradient(135deg, #FDE9E1, #F6C6C4);">
                            <i class="fas fa-star" style="color:#f74d6c;"></i>
                        </div>
                        <div class="value-icon-ring" style="border-color: rgba(247,77,108,0.2);"></div>
                    </div>
                    <h3>الجودة لا تتنازل</h3>
                    <p>بنستخدم أفضل البراندات الطبية العالمية ومش ممكن نوفر في جودة المنتج. جمالك يستحق الأفضل.</p>
                </div>
                <div class="value-card reveal" data-d="200">
                    <div class="value-icon-wrap">
                        <div class="value-icon" style="background: linear-gradient(135deg, #e8f8f0, #c8f0dc);">
                            <i class="fas fa-hand-holding-heart" style="color:#25D366;"></i>
                        </div>
                        <div class="value-icon-ring" style="border-color: rgba(37,211,102,0.2);"></div>
                    </div>
                    <h3>عناية مخصصة</h3>
                    <p>مفيش حاجة اسمها "حل واحد للجميع" عندنا. بنتعامل مع احتياجك الفردي بخطة عناية شخصية خاصة بيكي.</p>
                </div>
                <div class="value-card reveal" data-d="300">
                    <div class="value-icon-wrap">
                        <div class="value-icon" style="background: linear-gradient(135deg, #fef9e7, #fdebd0);">
                            <i class="fas fa-wand-magic-sparkles" style="color:#B08A3C;"></i>
                        </div>
                        <div class="value-icon-ring" style="border-color: rgba(176,138,60,0.2);"></div>
                    </div>
                    <h3>نتائج حقيقية</h3>
                    <p>الفرق هتحسي بيه بعينك من أول جلسة. مش وعود فاضية —  نتائج فعلية وصور قبل وبعد تتكلم عن نفسها.</p>
                </div>
                <div class="value-card reveal" data-d="100">
                    <div class="value-icon-wrap">
                        <div class="value-icon" style="background: linear-gradient(135deg, #f0e8ff, #e0ccff);">
                            <i class="fas fa-clock" style="color:#8B5CF6;"></i>
                        </div>
                        <div class="value-icon-ring" style="border-color: rgba(139,92,246,0.2);"></div>
                    </div>
                    <h3>احترام وقتك</h3>
                    <p>المواعيد عندنا ملتزمة، ووقتك مش هيتعدى. لأن احترام الوقت جزء من احترام العميلة.</p>
                </div>
                <div class="value-card reveal" data-d="200">
                    <div class="value-icon-wrap">
                        <div class="value-icon" style="background: linear-gradient(135deg, #fff0f3, #ffd6de);">
                            <i class="fas fa-comments" style="color:#f74d6c;"></i>
                        </div>
                        <div class="value-icon-ring" style="border-color: rgba(247,77,108,0.2);"></div>
                    </div>
                    <h3>تواصل مستمر</h3>
                    <p>مش بس جلسة وخلاص. بنتابع معاكي بعد الجلسة ونوفر نصايح عناية شخصية مجانية على واتساب.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TEAM SECTION ===== -->
    <section class="section about-team">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">فريقنا</span>
                <h2 class="sec-title">الأيدي الماهرة خلف <span class="gold">كل إبداع</span></h2>
                <p class="sec-sub">فريق متخصص ومتحمس، كل واحدة فيهم اتدربت وبتتدرب باستمرار</p>
            </div>
            <div class="team-grid">
                <div class="team-card reveal">
                    <div class="team-img">
                        <img src="assets/images/b&a3.jpeg" alt="نور الهدى">
                        <div class="team-social-overlay">
                            <a href="https://wa.me/201001234567" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <div class="team-badge">مؤسسة</div>
                        <h3>نور الهدى</h3>
                        <span class="team-role">مديرة الصالون ومتخصصة البشرة</span>
                        <p>أكثر من 8 سنوات في مجال التجميل والعناية بالبشرة. حاصلة على شهادات دولية في العلاج بالليزر والبشرة.</p>
                    </div>
                </div>
                <div class="team-card reveal" data-d="100">
                    <div class="team-img">
                        <img src="assets/images/b&a5.jpeg" alt="ريهام السيد">
                        <div class="team-social-overlay">
                            <a href="https://wa.me/201001234567" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <div class="team-badge" style="background: linear-gradient(135deg, #B08A3C, #D4AF61); color:#fff;">أخصائية شعر</div>
                        <h3>ريهام السيد</h3>
                        <span class="team-role">أخصائية علاجات الشعر والكيراتين</span>
                        <p>متخصصة في علاجات البروتين والكيراتين وصبغات الشعر الطبيعية. بتشتغل بشغف وحرفة عالية.</p>
                    </div>
                </div>
                <div class="team-card reveal" data-d="200">
                    <div class="team-img">
                        <img src="assets/images/b&a7.jpeg" alt="سمر خالد">
                        <div class="team-social-overlay">
                            <a href="https://wa.me/201001234567" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="team-info">
                        <div class="team-badge" style="background: linear-gradient(135deg, #1E1717, #3d2f2f); color:#fff;">أخصائية رموش</div>
                        <h3>سمر خالد</h3>
                        <span class="team-role">أخصائية الرموش ورفع الحواجب</span>
                        <p>خبرة 5 سنوات في تركيب الرموش والمكياج الاحترافي. يدها خفيفة وذوقها راقي ودائماً مميزة.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MILESTONES ===== -->
    <section class="about-milestones">
        <div class="container">
            <div class="milestones-inner">
                <div class="milestone-card reveal">
                    <i class="fas fa-award"></i>
                    <div class="milestone-num-wrap">
                        <div class="milestone-count" data-target="500">0</div>
                        <span class="milestone-plus">+</span>
                    </div>
                    <p>عميلة سعيدة</p>
                </div>
                <div class="milestone-card reveal" data-d="100">
                    <i class="fas fa-calendar-check"></i>
                    <div class="milestone-num-wrap">
                        <div class="milestone-count" data-target="1200">0</div>
                        <span class="milestone-plus">+</span>
                    </div>
                    <p>جلسة ناجحة</p>
                </div>
                <div class="milestone-card reveal" data-d="200">
                    <i class="fas fa-crown"></i>
                    <div class="milestone-num-wrap">
                        <div class="milestone-count" data-target="3">0</div>
                        <span class="milestone-plus">+</span>
                    </div>
                    <p>سنوات خبرة</p>
                </div>
                <div class="milestone-card reveal" data-d="300">
                    <i class="fas fa-star"></i>
                    <div class="milestone-num-wrap">
                        <div class="milestone-count" data-target="98">0</div>
                        <span class="milestone-plus">%</span>
                    </div>
                    <p>معدل الرضا</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== WHY US TIMELINE ===== -->
    <section class="section about-journey">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">رحلتنا</span>
                <h2 class="sec-title">من أول خطوة <span class="gold">لكل الإنجازات</span></h2>
            </div>
            <div class="journey-timeline">
                <div class="journey-line"></div>

                <div class="journey-item right reveal">
                    <div class="journey-dot"><i class="fas fa-seedling"></i></div>
                    <div class="journey-card">
                        <span class="journey-year">2026</span>
                        <h3>افتتاح فرع محرم بك</h3>
                        <p>بفرحة كبيرة، افتتحنا فرعنا الجديد في محرم بك بالإسكندرية (بجوار نادي الصيد) لنكون أقرب لكي وبمستوى تجهيزات عالمي.</p>
                    </div>
                </div>

                <div class="journey-item left reveal" data-d="100">
                    <div class="journey-dot" style="background: linear-gradient(135deg, #B08A3C, #D4AF61);"><i class="fas fa-users"></i></div>
                    <div class="journey-card">
                        <span class="journey-year">2023</span>
                        <h3>توسعنا وتطورنا</h3>
                        <p>وسعنا الفريق وأضفنا خدمات جديدة: علاجات الكيراتين المتخصصة وجلسات الرموش الاحترافية. وصلنا لأكثر من 200 عميلة.</p>
                    </div>
                </div>

                <div class="journey-item right reveal" data-d="200">
                    <div class="journey-dot" style="background: linear-gradient(135deg, #f74d6c, #ff7a95);"><i class="fas fa-certificate"></i></div>
                    <div class="journey-card">
                        <span class="journey-year">2024</span>
                        <h3>شهادات وتدريب دولي</h3>
                        <p>فريقنا حصل على شهادات من أكاديميات دولية متخصصة في العلاجات الحديثة. وبدأنا نقدم خدمات الأوكسجينو والديرمابن.</p>
                    </div>
                </div>

                <div class="journey-item left reveal" data-d="300">
                    <div class="journey-dot" style="background: linear-gradient(135deg, #25D366, #128C7E);"><i class="fas fa-star"></i></div>
                    <div class="journey-card">
                        <span class="journey-year">2025 — الآن</span>
                        <h3>نمو مستمر</h3>
                        <p>تجاوزنا 500 عميلة سعيدة ومازلنا في تقدم. بنحسن خدماتنا باستمرار ومستنيين نستقبلك قريباً!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS MINI ===== -->
    <section class="section about-reviews" style="background:#fff;">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">آراء عميلاتنا</span>
                <h2 class="sec-title">كلامهم هو أحلى <span class="gold">شهادة</span></h2>
            </div>
            <div class="rev-grid">
                <div class="rev-card reveal">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"المكان مريح جداً والبنات محترفات. حسيت إنهم فعلاً شايفين احتياجي وشغلانين عليه. Natural Hub هو مكاني الأول والأخير للعناية."</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a3.jpeg" alt="دينا ماهر">
                        <div>
                            <strong>دينا ماهر</strong>
                            <span>جلسة بروتين + رموش</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
                <div class="rev-card reveal" data-d="100">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"بعت بنتي للصالون وكنت قلقانة، بس الله عليهم قابلوها باحترام وعنايا وعملوا شغل جميل جداً. شكراً Natural Hub على الأمانة والإتقان."</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a5.jpeg" alt="أميرة فاروق">
                        <div>
                            <strong>أميرة فاروق</strong>
                            <span>علاج بشرة متخصص</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
                <div class="rev-card reveal" data-d="200">
                    <div class="rev-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="rev-text">"عملت جلسة أوكسجينو للبشرة والنتيجة كانت مذهلة! بشرتي بقت أنعم وبقت صافية جداً والمسام صغرت. ماشاء الله على الفريق الجميل ده!"</p>
                    <div class="rev-author">
                        <img src="assets/images/b&a8.jpeg" alt="هبة إبراهيم">
                        <div>
                            <strong>هبة إبراهيم</strong>
                            <span>جلسة أوكسجينو للبشرة</span>
                        </div>
                    </div>
                    <i class="fas fa-quote-right rev-quote"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="about-final-cta">
        <div class="about-cta-bg"></div>
        <div class="container about-cta-inner">
            <div class="about-cta-text">
                <h2>مستنياكي في Natural Hub 🌿</h2>
                <p>تعالي جربي الفرق بنفسك. احجزي جلستك دلوقتي وابدأي رحلة عنايتك مع فريق بيحب شغله وبيهتم بيكي.</p>
                <div class="cta-actions">
                    <a href="https://wa.me/201001234567" class="btn wa-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> احجزي عبر واتساب
                    </a>
                    <a href="tel:+201001234567" class="btn wa-ghost-btn">
                        <i class="fas fa-phone"></i> اتصلي بينا
                    </a>
                </div>
            </div>
            <div class="about-cta-floaters">
                <div class="cta-float-card fc1"><i class="fas fa-spa"></i><span>علاجات شعر</span></div>
                <div class="cta-float-card fc2"><i class="fas fa-eye"></i><span>رموش فاخرة</span></div>
                <div class="cta-float-card fc3"><i class="fas fa-sun"></i><span>عناية بشرة</span></div>
                <div class="cta-float-card fc4"><i class="fas fa-box-open"></i><span>أفتر كير</span></div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/about.js') }}"></script>
@endpush
