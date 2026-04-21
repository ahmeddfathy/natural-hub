/* =============================================
   NATURAL HUB — Blog JavaScript
   ============================================= */

(function () {
    'use strict';

    /* ════════════════════════════════
       POSTS DATA
    ════════════════════════════════ */
    const POSTS = [
        {
            id: 1,
            cat: 'hair',
            catLabel: 'الشعر',
            catIcon: 'fa-wand-magic-sparkles',
            catClass: 'hair-cat-chip',
            title: 'كيف تعتني بشعرك بعد جلسة البروتين؟',
            excerpt: 'أهم النصائح للحفاظ على نتيجة البروتين أطول فترة ممكنة — من اختيار الشامبو الصح لحد مواعيد الغسيل.',
            img: 'assets/images/1.jpeg',
            date: '١٠ أبريل ٢٠٢٦',
            readTime: '٥ دقائق',
            views: '١٢٠٠',
            featured: true,
            url: 'blog-post.html'
        },
        {
            id: 2,
            cat: 'skin',
            catLabel: 'البشرة',
            catIcon: 'fa-sun',
            catClass: 'skin-cat-chip',
            title: 'أسرار الحصول على بشرة مشرقة طبيعياً',
            excerpt: 'روتين بسيط من ٥ خطوات يخلي بشرتك صافية ومشرقة بمنتجات طبيعية متاحة بسهولة.',
            img: 'assets/images/b&a1.jpeg',
            date: '٥ أبريل ٢٠٢٦',
            readTime: '٤ دقائق',
            views: '٩٨٠',
            featured: false,
            url: 'blog-post.html'
        },
        {
            id: 3,
            cat: 'lash',
            catLabel: 'الرموش',
            catIcon: 'fa-eye',
            catClass: 'lash-cat-chip',
            title: 'كيف تختاري الرموش اللي تناسب عيونك؟',
            excerpt: 'دليلك الشامل لاختيار نوع الرموش المناسب لشكل عيونك — كلاسيك، روسي، هايبرد، أو ميجا فوليوم.',
            img: 'assets/images/b&a3.jpeg',
            date: '١ أبريل ٢٠٢٦',
            readTime: '٣ دقائق',
            views: '٨٥٠',
            featured: false,
            url: 'blog-post.html'
        },
        {
            id: 4,
            cat: 'tips',
            catLabel: 'نصائح عامة',
            catIcon: 'fa-lightbulb',
            catClass: 'tips-cat-chip',
            title: 'دليلك لاختيار مجموعة الأفتر كير المناسبة لشعرك',
            excerpt: 'كل نوع شعر محتاج عناية مختلفة. في المقالة دي هنشرحلك الفرق بين المجموعات الوردية والخضراء والسوداء.',
            img: 'assets/images/1.jpeg',
            date: '٢٨ مارس ٢٠٢٦',
            readTime: '٥ دقائق',
            views: '١٨٠٠',
            featured: false,
            url: 'shop.html'
        },
        {
            id: 5,
            cat: 'hair',
            catLabel: 'الشعر',
            catIcon: 'fa-wand-magic-sparkles',
            catClass: 'hair-cat-chip',
            title: 'الفرق بين الكيراتين والبروتين — أيهما يناسبك؟',
            excerpt: 'مقارنة شاملة بين الجلستين الأشهر لعلاج الشعر — وإيه اللي يناسب نوعك وطبيعة شعرك بالتحديد.',
            img: 'assets/images/b&a2.jpeg',
            date: '٢٢ مارس ٢٠٢٦',
            readTime: '٥ دقائق',
            views: '١٥٠٠',
            featured: false,
            url: 'blog-post.html'
        },
        {
            id: 6,
            cat: 'tips',
            catLabel: 'نصائح عامة',
            catIcon: 'fa-lightbulb',
            catClass: 'tips-cat-chip',
            title: '١٠ عادات يومية تجعلك تبدين أصغر سناً',
            excerpt: 'نصائح عملية من خبراء Natural Hub في العناية بالبشرة والشعر تساعدك تحافظي على شبابك وجمالك.',
            img: 'assets/images/b&a5.jpeg',
            date: '١٥ مارس ٢٠٢٦',
            readTime: '٤ دقائق',
            views: '٧٨٠',
            featured: false,
            url: 'blog-post.html'
        }
    ];

    /* ════════════════════════════════
       RENDER FEATURED (HERO)
    ════════════════════════════════ */
    const featuredEl = document.getElementById('heroFeatured');
    if (featuredEl) {
        const f = POSTS.find(p => p.featured) || POSTS[0];
        featuredEl.innerHTML = `
            <a href="${f.url}" class="blog-featured-card">
                <span class="blog-featured-tag">الأكثر قراءة</span>
                <img src="${f.img}" alt="${f.title}" class="blog-featured-img">
                <div class="blog-featured-grad"></div>
                <div class="blog-featured-body">
                    <div class="blog-cat-chip ${f.catClass} blog-featured-chip">
                        <i class="fas ${f.catIcon}"></i> ${f.catLabel}
                    </div>
                    <h2>${f.title}</h2>
                    <div class="blog-featured-meta">
                        <span><i class="fas fa-calendar-alt"></i> ${f.date}</span>
                        <span><i class="fas fa-clock"></i> ${f.readTime}</span>
                        <span><i class="fas fa-eye"></i> ${f.views}</span>
                    </div>
                </div>
            </a>`;
    }

    /* ════════════════════════════════
       RENDER GRID
    ════════════════════════════════ */
    const grid    = document.getElementById('blogGrid');
    const emptyEl = document.getElementById('blogEmpty');
    const countEl = document.getElementById('blogCount');

    function renderCards(posts) {
        if (!grid) return;
        if (posts.length === 0) {
            grid.innerHTML = '';
            if (emptyEl) emptyEl.style.display = 'block';
            if (countEl) countEl.textContent = '٠ مقالات';
            return;
        }

        if (emptyEl) emptyEl.style.display = 'none';
        if (countEl) countEl.textContent = posts.length + ' مقالات';

        grid.innerHTML = posts.map(p => `
            <a href="${p.url}" class="blog-card" data-cat="${p.cat}">
                <div class="blog-card-img">
                    <img src="${p.img}" alt="${p.title}" loading="lazy">
                </div>
                <div class="blog-card-body">
                    <span class="blog-cat-chip ${p.catClass}">
                        <i class="fas ${p.catIcon}"></i> ${p.catLabel}
                    </span>
                    <h2 class="blog-card-title">${p.title}</h2>
                    <p class="blog-card-excerpt">${p.excerpt}</p>
                    <div class="blog-card-footer">
                        <div class="blog-card-meta">
                            <span><i class="fas fa-calendar-alt"></i> ${p.date}</span>
                            <span><i class="fas fa-clock"></i> ${p.readTime}</span>
                        </div>
                        <span class="blog-card-read">اقرأي <i class="fas fa-arrow-left"></i></span>
                    </div>
                </div>
            </a>
        `).join('');

        // Animate in
        grid.querySelectorAll('.blog-card').forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, i * 70);
        });
    }

    let currentCat  = 'all';
    let searchQuery = '';

    function filterPosts() {
        return POSTS.filter(p => {
            const matchCat  = currentCat === 'all' || p.cat === currentCat;
            const matchSearch = !searchQuery || p.title.includes(searchQuery) || p.excerpt.includes(searchQuery);
            return matchCat && matchSearch;
        });
    }

    renderCards(POSTS);

    /* ════════════════════════════════
       CATEGORY FILTER
    ════════════════════════════════ */
    const catBtns = document.querySelectorAll('.blog-cat');
    catBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            catBtns.forEach(b => { b.classList.remove('active'); b.setAttribute('aria-selected', 'false'); });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            currentCat = btn.dataset.cat;
            renderCards(filterPosts());
        });
    });

    /* ════════════════════════════════
       SEARCH
    ════════════════════════════════ */
    const searchInput = document.getElementById('blogSearch');
    const searchClear = document.getElementById('blogSearchClear');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            searchQuery = searchInput.value.trim();
            if (searchClear) searchClear.classList.toggle('show', searchQuery.length > 0);
            renderCards(filterPosts());
        });
    }

    if (searchClear) {
        searchClear.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            searchQuery = '';
            searchClear.classList.remove('show');
            renderCards(filterPosts());
        });
    }

    /* Reset button (empty state) */
    const resetBtn = document.getElementById('blogReset');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            currentCat = 'all';
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            catBtns.forEach(b => b.classList.toggle('active', b.dataset.cat === 'all'));
            renderCards(POSTS);
        });
    }

    /* ════════════════════════════════
       NAVBAR + SCROLL
    ════════════════════════════════ */
    const navbar  = document.getElementById('navbar');
    const btt     = document.getElementById('btt');
    const waFloat = document.getElementById('waFloat');
    const navProgress = document.getElementById('navProgress');

    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (navbar)  navbar.classList.toggle('scrolled', y > 60);
        if (btt)     btt.classList.toggle('visible',     y > 400);
        if (waFloat) waFloat.classList.toggle('visible', y > 200);

        if (navProgress) {
            const docH = document.documentElement.scrollHeight - window.innerHeight;
            const pct = docH > 0 ? (y / docH) * 100 : 0;
            navProgress.style.width = pct + '%';
        }

    }, { passive: true });

    if (btt) btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    const burger  = document.getElementById('burger');
    const navMenu = document.getElementById('navMenu');
    const navClose = document.getElementById('navClose');
    let overlay = null;

    const mkOverlay = () => {
        overlay = document.createElement('div');
        overlay.className = 'nav-overlay';
        document.body.appendChild(overlay);
        overlay.addEventListener('click', closeNav);
    };

    const openNav = () => {
        navMenu.classList.add('on');
        burger.classList.add('open');
        if (!overlay) mkOverlay();
        requestAnimationFrame(() => overlay.classList.add('on'));
        document.body.classList.add('nav-open');
        document.body.style.overflow = 'hidden';
    };

    const closeNav = () => {
        navMenu.classList.remove('on');
        burger.classList.remove('open');
        if (overlay) overlay.classList.remove('on');
        document.body.classList.remove('nav-open');
        document.body.style.overflow = '';
    };

    if (burger && navMenu) {
        burger.addEventListener('click', () => navMenu.classList.contains('on') ? closeNav() : openNav());
        if (navClose) navClose.addEventListener('click', closeNav);
        navMenu.querySelectorAll('li > a').forEach(a => a.addEventListener('click', closeNav));
    }



})();
