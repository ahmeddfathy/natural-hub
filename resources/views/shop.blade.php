@extends('layouts.app')

@section('title', 'المتجر | Natural Hub — منتجات العناية الفاخرة')
@section('meta_description', 'تسوقي أفضل منتجات العناية بالشعر والبشرة من Natural Hub.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/shop.css') }}">
@endpush

@section('content')
<main>
        <!-- ===== MASTER HERO ===== -->
        <section class="master-hero mh-centered" id="shop-hero">
            <div class="mh-bg">
                <div class="mh-overlay"></div>
                <div class="mh-glows"></div>
                <div class="mh-particles">
                    <span class="p1"></span><span class="p2"></span><span class="p3"></span><span class="p4"></span>
                </div>
            </div>
            <div class="container mh-inner">
                <div class="mh-content">
                    <span class="mh-tag"><i class="fas fa-shopping-bag"></i> منتجاتنا الحصرية</span>
                    <h1 class="mh-title">جمالكِ <br><span class="mh-accent">بين يديكِ</span></h1>
                    <p class="mh-desc">مجموعات العناية المنزلية (Aftercare) المختارة بعناية فائقة لتضمن لكِ استمرار نتائج الجلسات الاحترافية وصحة شعركِ وبشرتكِ.</p>
                    <div class="mh-btns">
                        <a href="#shop-grid" class="mh-btn-primary">تسوقي الآن</a>
                        <a href="https://wa.me/201001234567" class="mh-btn-outline" target="_blank"><i class="fab fa-whatsapp"></i> اطلبي عبر واتساب</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===== PRODUCTS SECTION ===== -->
        <section class="section">
            <div class="container">
                
                <!-- Filter Tabs -->
                <div class="shop-filters">
                    <button class="filter-btn active" data-filter="all">الكل</button>
                    <button class="filter-btn" data-filter="sets">مجموعات كاملة</button>
                    <button class="filter-btn" data-filter="individual">قطع فردية</button>
                </div>

                <div class="shop-grid" id="shop-grid">

                    {{-- Bundles من الـ DB --}}
                    @forelse($bundles as $bundle)
                    <div class="product-card" data-category="sets">
                        @if($bundle->badge)
                        <div class="product-badge">{{ $bundle->badge }}</div>
                        @endif
                        <div class="product-img">
                            <img src="{{ $bundle->image ? asset('storage/'.$bundle->image) : asset('assets/images/1.jpeg') }}"
                                 alt="{{ $bundle->name }}">
                        </div>
                        <div class="product-content">
                            <span class="product-cat">{{ $bundle->subtitle }}</span>
                            <h3 class="product-title">{{ $bundle->name }}</h3>
                            <p class="product-desc">{{ $bundle->description }}</p>
                            @if($bundle->products->count())
                            <div class="product-variants">
                                @foreach($bundle->products as $p)
                                <span class="variant-tag">{{ $p->name }}</span>
                                @endforeach
                            </div>
                            @endif
                            <div class="product-footer">
                                <div class="product-price">{{ $bundle->price_label }} <span>ج.م</span></div>
                                <a href="https://wa.me/201001234567?text={{ urlencode('أريد طلب '.$bundle->name) }}"
                                   class="add-to-cart" target="_blank">
                                    <i class="fas fa-shopping-bag"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    {{-- Fallback static bundles --}}
                    <div class="product-card" data-category="sets">
                        <div class="product-badge">الأكثر مبيعاً</div>
                        <div class="product-img"><img src="{{ asset('assets/images/1.jpeg') }}" alt="Pink Set"></div>
                        <div class="product-content">
                            <span class="product-cat">للشعر العادي والدهني</span>
                            <h3 class="product-title">المجموعة الوردية (Pink)</h3>
                            <p class="product-desc">مجموعة متكاملة مصممة خصيصاً للشعر العادي والدهني.</p>
                            <div class="product-footer">
                                <div class="product-price">١٠٠٠ / ٨٠٠ <span>ج.م</span></div>
                                <a href="https://wa.me/201001234567?text={{ urlencode('أريد طلب المجموعة الوردية (Pink)') }}"
                                   class="add-to-cart" target="_blank"><i class="fas fa-shopping-bag"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforelse

                    {{-- Products فردية من الـ DB --}}
                    @foreach($products as $product)
                    <div class="product-card" data-category="individual">
                        <div class="product-img">
                            <img src="{{ $product->image ? asset('storage/'.$product->image) : asset('assets/images/1.jpeg') }}"
                                 alt="{{ $product->name }}">
                        </div>
                        <div class="product-content">
                            <span class="product-cat">{{ $product->subtitle ?? 'عناية فردية' }}</span>
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <p class="product-desc">{{ $product->description }}</p>
                            <div class="product-footer">
                                <div class="product-price">{{ $product->price_label }} <span>ج.م</span></div>
                                <a href="https://wa.me/201001234567?text={{ urlencode('أريد طلب '.$product->name) }}"
                                   class="add-to-cart" target="_blank">
                                    <i class="fas fa-shopping-bag"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </section>

                    
                    <!-- ===== CTA SECTION ===== -->
        <section class="container">
            <div class="shop-cta">
                <div class="shop-cta-inner">
                    <h2>محتاجة استشارة؟ 🌿</h2>
                    <p>تواصلي معنا على واتساب لنساعدك في اختيار المجموعة الأنسب لنوع شعرك.</p>
                    <a href="https://wa.me/201001234567" class="btn pink-btn" target="_blank">تحدثي إلينا الآن</a>
                </div>
            </div>
        </section>

    </main>

@endsection

@push('scripts')

@endpush
