@extends('layouts.app')

@section('title', $blog->meta_title ?: ($blog->title . ' | مدونة Natural Hub'))
@section('meta_description', $blog->meta_description ?: Str::limit(strip_tags($blog->content), 160))
@section('body_class', 'post-page-body')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog.css') }}">
@endpush

@section('content')
<article class="post-page">

    <!-- ===== POST HERO ===== -->
    <header class="post-hero">
        <div class="post-hero-img">
            <img src="{{ $blog->cover_image ? asset('storage/'.$blog->cover_image) : asset('assets/images/1.jpeg') }}"
                 alt="{{ $blog->title }}">
            <div class="post-hero-overlay"></div>
        </div>
        <div class="container post-hero-content">
            <div class="post-breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <i class="fas fa-chevron-left"></i>
                <a href="{{ route('blog.index') }}">المدونة</a>
                @if($blog->category)
                <i class="fas fa-chevron-left"></i>
                <a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}">
                    {{ $blog->category->name }}
                </a>
                @endif
            </div>

            @if($blog->category)
            <div class="post-hero-badge">
                {{ $blog->category->name }}
            </div>
            @endif

            <h1 class="post-hero-title">{{ $blog->title }}</h1>

            <div class="post-meta-row">
                <div class="post-meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $blog->published_at?->translatedFormat('d F Y') }}
                </div>
                @if($blog->read_time)
                <div class="post-meta-item">
                    <i class="fas fa-clock"></i> {{ $blog->read_time }} دقائق قراءة
                </div>
                @endif
                @if($blog->views_count)
                <div class="post-meta-item">
                    <i class="fas fa-eye"></i> {{ number_format($blog->views_count) }} مشاهدة
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- ===== POST BODY ===== -->
    <div class="post-layout container">

        <!-- MAIN CONTENT -->
        <div class="post-content">

            @if($blog->excerpt)
            <div class="post-intro">{{ $blog->excerpt }}</div>
            @endif

            <div class="post-body-content">
                {!! $blog->content !!}
            </div>

            <!-- TAGS -->
            @if($blog->meta_keywords)
            <div class="post-tags">
                @foreach(explode(',', $blog->meta_keywords) as $tag)
                <span class="post-tag"><i class="fas fa-tag"></i> {{ trim($tag) }}</span>
                @endforeach
            </div>
            @endif

            <!-- SHARE -->
            <div class="post-share">
                <span class="post-share-label">شاركي المقالة:</span>
                @php $postUrl = urlencode(request()->url()); $postTitle = urlencode($blog->title); @endphp
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $postUrl }}"
                   target="_blank" class="share-btn share-fb" aria-label="فيسبوك">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://wa.me/?text={{ $postTitle }}%20{{ $postUrl }}"
                   target="_blank" class="share-btn share-wa" aria-label="واتساب">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ $postUrl }}&text={{ $postTitle }}"
                   target="_blank" class="share-btn share-tw" aria-label="تويتر">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://t.me/share/url?url={{ $postUrl }}&text={{ $postTitle }}"
                   target="_blank" class="share-btn share-tg" aria-label="تيليجرام">
                    <i class="fab fa-telegram-plane"></i>
                </a>
            </div>

        </div><!-- /post-content -->

        <!-- SIDEBAR -->
        <aside class="post-sidebar">

            <!-- Book CTA -->
            <div class="sidebar-card sidebar-cta">
                <div class="sidebar-cta-icon"><i class="fas fa-spa"></i></div>
                <h3>احجزي جلستك الآن</h3>
                <p>استمتعي بعناية احترافية مع فريق Natural Hub المتخصص.</p>
                <a href="https://wa.me/201001234567" class="btn wa-btn" target="_blank"
                   style="width:100%;justify-content:center;">
                    <i class="fab fa-whatsapp"></i> احجزي عبر واتساب
                </a>
            </div>

            <!-- Categories -->
            @if($categories->count())
            <div class="sidebar-card">
                <h3><i class="fas fa-tags"></i> التصنيفات</h3>
                <ul class="sidebar-cats-list">
                    @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('blog.index', ['category' => $cat->slug]) }}">
                            {{ $cat->name }}
                            <span class="sidebar-cat-count">{{ $cat->blogs_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Recent Posts -->
            @if($recentBlogs->count())
            <div class="sidebar-card sidebar-related">
                <h3><i class="fas fa-newspaper"></i> أحدث المقالات</h3>
                <div class="related-list">
                    @foreach($recentBlogs as $recent)
                    <a href="{{ route('blog.show', $recent->slug) }}" class="related-item">
                        <img src="{{ $recent->cover_image ? asset('storage/'.$recent->cover_image) : asset('assets/images/1.jpeg') }}"
                             alt="{{ $recent->title }}">
                        <div>
                            <p>{{ Str::limit($recent->title, 55) }}</p>
                            @if($recent->read_time)
                                <span>{{ $recent->read_time }} دقائق</span>
                            @endif
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </aside><!-- /sidebar -->
    </div><!-- /post-layout -->

    <!-- ===== RELATED POSTS BOTTOM ===== -->
    @if($relatedBlogs->count())
    <section class="post-related-section">
        <div class="container">
            <div class="sec-head">
                <span class="sec-chip">اقرأي أيضاً</span>
                <h2 class="sec-title">مقالات <span class="gold">قد تعجبك</span></h2>
            </div>
            <div class="post-related-grid">
                @foreach($relatedBlogs as $related)
                <a href="{{ route('blog.show', $related->slug) }}" class="pr-card">
                    <div class="pr-card-img">
                        <img src="{{ $related->cover_image ? asset('storage/'.$related->cover_image) : asset('assets/images/1.jpeg') }}"
                             alt="{{ $related->title }}" loading="lazy">
                    </div>
                    <div class="pr-card-body">
                        @if($related->category)
                            <span class="pr-cat">{{ $related->category->name }}</span>
                        @endif
                        <h3>{{ $related->title }}</h3>
                        <div class="pr-meta">
                            @if($related->read_time)
                                <span><i class="fas fa-clock"></i> {{ $related->read_time }} دقائق</span>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</article>

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
