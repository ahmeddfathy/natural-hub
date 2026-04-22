@extends('layouts.app')

@section('title', 'المدونة | Natural Hub — نصائح الجمال والعناية')
@section('meta_description', 'مدونة Natural Hub — نصائح احترافية في العناية بالشعر والبشرة والرموش.')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@section('content')

    <!-- ===== MASTER HERO ===== -->
    <section class="master-hero mh-centered" id="blog-hero">
        <div class="mh-bg">
            <div class="mh-overlay"></div>
            <div class="mh-glows"></div>
            <div class="mh-particles">
                <span class="p1"></span><span class="p2"></span><span class="p3"></span><span class="p4"></span>
            </div>
        </div>
        <div class="container mh-inner">
            <div class="mh-content">
                <span class="mh-tag"><i class="fas fa-newspaper"></i> نصائح جمالية</span>
                <h1 class="mh-title">جمالكِ <br><span class="mh-accent">يبدأ بالمعرفة</span></h1>
                <p class="mh-desc">نشارككِ أحدث النصائح والتوجهات في عالم العناية بالشعر والبشرة والرموش من واقع خبرتنا اليومية مع عميلاتنا.</p>
                <form method="GET" action="{{ route('blog.index') }}" class="blog-search-wrap" style="position:relative;max-width:500px;margin:10px auto 0;">
                    <i class="fas fa-search" style="position:absolute;right:22px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.4);font-size:0.9rem;"></i>
                    <input type="text" name="search" id="blogSearch" class="blog-search-input"
                           value="{{ request('search') }}"
                           placeholder="ابحثي عن نصيحة جمالية…" autocomplete="off"
                           style="width:100%;padding:18px 55px 18px 25px;background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.1);border-radius:50px;color:#fff;font-family:inherit;font-size:1rem;outline:none;transition:all 0.4s ease;backdrop-filter:blur(20px);">
                </form>
            </div>
        </div>
    </section>

    <!-- ===== CATEGORY FILTER ===== -->
    <div class="blog-filter-bar" id="blogFilterBar">
        <div class="container blog-filter-inner">
            <div class="blog-cats" id="blogCats" role="tablist">
                <a href="{{ route('blog.index') }}"
                   class="blog-cat {{ !request('category') ? 'active' : '' }}" role="tab">
                    <i class="fas fa-grip-horizontal"></i> الكل
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}"
                   class="blog-cat {{ request('category') == $cat->slug ? 'active' : '' }}" role="tab">
                    {{ $cat->name }}
                    @if($cat->blogs_count > 0)
                        <span class="blog-cat-count">{{ $cat->blogs_count }}</span>
                    @endif
                </a>
                @endforeach
            </div>
            <div class="blog-count" id="blogCount">{{ $blogs->total() }} مقالة</div>
        </div>
    </div>

    <!-- ===== FEATURED STRIP (أحدث 3 مقالات) ===== -->
    @if(!request('search') && !request('category') && $featuredBlogs->count())
    <section class="blog-featured-strip">
        <div class="container">
            <div class="blog-grid blog-grid-featured">
                @foreach($featuredBlogs as $featured)
                <a href="{{ route('blog.show', $featured->slug) }}" class="blog-card blog-card-featured">
                    <div class="blog-card-img">
                        <img src="{{ $featured->cover_image ? asset('storage/'.$featured->cover_image) : asset('assets/images/1.jpeg') }}"
                             alt="{{ $featured->title }}" loading="lazy">
                    </div>
                    <div class="blog-card-body">
                        @if($featured->category)
                            <span class="blog-cat-badge">{{ $featured->category->name }}</span>
                        @endif
                        <h2 class="blog-card-title">{{ $featured->title }}</h2>
                        <p class="blog-card-excerpt">{{ Str::limit($featured->excerpt ?? strip_tags($featured->content), 100) }}</p>
                        <div class="blog-card-meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ $featured->published_at?->format('d M Y') }}</span>
                            @if($featured->read_time)
                                <span><i class="fas fa-clock"></i> {{ $featured->read_time }} دقائق</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ===== POSTS GRID ===== -->
    <section class="blog-section">
        <div class="container">

            @if($blogs->count())
            <div class="blog-grid" id="blogGrid">
                @foreach($blogs as $post)
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-card">
                    <div class="blog-card-img">
                        <img src="{{ $post->cover_image ? asset('storage/'.$post->cover_image) : asset('assets/images/1.jpeg') }}"
                             alt="{{ $post->title }}" loading="lazy">
                    </div>
                    <div class="blog-card-body">
                        @if($post->category)
                            <span class="blog-cat-badge">{{ $post->category->name }}</span>
                        @endif
                        <h3 class="blog-card-title">{{ $post->title }}</h3>
                        <p class="blog-card-excerpt">{{ Str::limit($post->excerpt ?? strip_tags($post->content), 90) }}</p>
                        <div class="blog-card-meta">
                            <span><i class="fas fa-calendar-alt"></i> {{ $post->published_at?->format('d M Y') }}</span>
                            @if($post->read_time)
                                <span><i class="fas fa-clock"></i> {{ $post->read_time }} دقائق</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($blogs->hasPages())
            <div class="blog-pagination mt-4 d-flex justify-content-center">
                {{ $blogs->withQueryString()->links() }}
            </div>
            @endif

            @else
            <div class="blog-empty" id="blogEmpty">
                <i class="fas fa-newspaper"></i>
                <h3>ما فيش نتائج</h3>
                <p>جربي كلمة بحث تانية أو اختاري تصنيف مختلف</p>
                <a href="{{ route('blog.index') }}" class="btn pink-btn sm">عرض الكل</a>
            </div>
            @endif

        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="awesome-cta">
        <div class="container cta-container">
            <div class="cta-text-side">
                <h2>احجزي الآن <span style="color:#f74d6c">جمالك مش ممكن يستنى ✨</span></h2>
                <p>خطوة واحدة بس تفصلك عن تجربة عناية مختلفة تماماً. تواصلي معانا دلوقتي واحجزي جلستك.</p>
                <div class="cta-actions">
                    <a href="https://wa.me/201001234567" class="btn wa-btn" target="_blank">
                        <i class="fab fa-whatsapp"></i> احجزي عبر واتساب
                    </a>
                    <a href="tel:+201001234567" class="btn wa-ghost-btn">
                        <i class="fas fa-phone"></i> اتصلي بينا
                    </a>
                </div>
            </div>
            <div class="cta-img-side">
                <img src="{{ asset('assets/images/cta.jpeg') }}" alt="Natural Hub Spa" loading="lazy">
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/blog.js') }}"></script>
@endpush
