{{-- ===== NAVBAR ===== --}}
<div class="nav-progress" id="navProgress"></div>
<nav class="navbar clean-navbar" id="navbar">
    <div class="container nav-flex">
        <a href="{{ url('/') }}" class="logo-clean">
            <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Natural Hub" class="site-logo">
        </a>

        <ul class="nav-menu" id="navMenu">
            <div class="nav-mobile-header">
                <span class="nav-mobile-header-title">القائمة</span>
                <button class="nav-mobile-header-close" id="navClose" aria-label="إغلاق"><i class="fas fa-times"></i></button>
            </div>
            <li><a href="{{ url('/') }}"           class="{{ request()->is('/') ? 'active-link' : '' }}"><i class="fas fa-home nav-icon"></i> الرئيسية</a></li>
            <li><a href="{{ url('/services') }}"   class="{{ request()->is('services') ? 'active-link' : '' }}"><i class="fas fa-spa nav-icon"></i> الخدمات</a></li>
            <li><a href="{{ url('/gallery') }}"    class="{{ request()->is('gallery') ? 'active-link' : '' }}"><i class="fas fa-images nav-icon"></i> المعرض</a></li>
            <li><a href="{{ url('/videos') }}"     class="{{ request()->is('videos') ? 'active-link' : '' }}"><i class="fas fa-play-circle nav-icon"></i> الفيديوهات</a></li>
            <li><a href="{{ url('/shop') }}"       class="{{ request()->is('shop') ? 'active-link' : '' }}"><i class="fas fa-shopping-bag nav-icon"></i> المتجر</a></li>
            <li><a href="{{ url('/blog') }}"       class="{{ request()->is('blog*') ? 'active-link' : '' }}"><i class="fas fa-newspaper nav-icon"></i> المدونة</a></li>
            <li><a href="{{ url('/about') }}"      class="{{ request()->is('about') ? 'active-link' : '' }}"><i class="fas fa-heart nav-icon"></i> من نحن</a></li>
            <li><a href="{{ url('/contact') }}"    class="{{ request()->is('contact') ? 'active-link' : '' }}"><i class="fas fa-envelope nav-icon"></i> تواصل معنا</a></li>
            <div class="nav-mobile-footer">
                <a href="https://wa.me/201001234567" class="btn pink-btn" target="_blank"><i class="fab fa-whatsapp"></i> احجزي جلستك</a>
                <div class="nav-mobile-social">
                    <a href="https://www.facebook.com/NaturalHubSkincare" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </ul>

        <div class="nav-actions-clean">
            <a href="https://wa.me/201001234567" class="btn pink-btn" target="_blank">احجزي جلستك</a>
            <button class="burger" id="burger" aria-label="القائمة">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>
