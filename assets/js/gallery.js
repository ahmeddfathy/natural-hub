/* =============================================
   NATURAL HUB — Gallery JS v3
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Navbar scroll ── */
    const navbar = document.getElementById('navbar');
    const btt    = document.getElementById('btt');
    const onScroll = () => {
        navbar.classList.toggle('scrolled', window.scrollY > 60);
        btt.classList.toggle('show', window.scrollY > 400);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* ── Mobile menu ── */
    const burger  = document.getElementById('burger');
    const navMenu = document.getElementById('navMenu');
    let overlay   = null;
    const mkOverlay = () => {
        overlay = document.createElement('div');
        overlay.className = 'nav-overlay';
        document.body.appendChild(overlay);
        overlay.addEventListener('click', closeNav);
    };
    const openNav = () => {
        navMenu.classList.add('on'); burger.classList.add('open');
        if (!overlay) mkOverlay();
        requestAnimationFrame(() => overlay.classList.add('on'));
        document.body.style.overflow = 'hidden';
    };
    const closeNav = () => {
        navMenu.classList.remove('on'); burger.classList.remove('open');
        if (overlay) overlay.classList.remove('on');
        document.body.style.overflow = '';
    };
    burger.addEventListener('click', () => navMenu.classList.contains('on') ? closeNav() : openNav());
    navMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeNav));

    /* ══════════════════════════════
       ARROW BUTTONS — scroll track
       ══════════════════════════════ */
    document.querySelectorAll('.gl-arrow').forEach(btn => {
        btn.addEventListener('click', () => {
            const id    = btn.dataset.track;
            const track = document.getElementById(`track-${id}`);
            if (!track) return;

            // Scroll amount = card width + gap (~236px)
            const amount = 236;
            if (btn.classList.contains('gl-arrow-prev')) {
                track.scrollBy({ left: -amount, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: amount, behavior: 'smooth' });
            }
        });
    });

    /* ══════════════════════════════
       DRAG-TO-SCROLL (mouse)
       ══════════════════════════════ */
    document.querySelectorAll('.gl-track').forEach(track => {
        let isDown = false, startX, scrollLeft;

        track.addEventListener('mousedown', e => {
            isDown     = true;
            startX     = e.pageX - track.offsetLeft;
            scrollLeft = track.scrollLeft;
            track.style.cursor = 'grabbing';
        });
        track.addEventListener('mouseleave', () => { isDown = false; track.style.cursor = 'grab'; });
        track.addEventListener('mouseup',    () => { isDown = false; track.style.cursor = 'grab'; });
        track.addEventListener('mousemove',  e => {
            if (!isDown) return;
            e.preventDefault();
            const x    = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 1.4;
            track.scrollLeft = scrollLeft - walk;
        });
    });

    /* ══════════════════════════════
       LIGHTBOX
       ══════════════════════════════ */
    const lightbox  = document.getElementById('glLightbox');
    const backdrop  = document.getElementById('glLbBackdrop');
    const lbImg     = document.getElementById('glLbImg');
    const lbTitle   = document.getElementById('glLbTitle');
    const lbDesc    = document.getElementById('glLbDesc');
    const lbClose   = document.getElementById('glLbClose');
    const lbPrev    = document.getElementById('glLbPrev');
    const lbNext    = document.getElementById('glLbNext');
    const lbImgWrap = lbImg.parentElement;

    let lbPool  = [];   // cards in the current carousel section
    let lbIndex = 0;

    function openLightbox(clickedCard, pool) {
        lbPool  = pool;
        lbIndex = pool.indexOf(clickedCard);
        loadCard(lbIndex);
        lightbox.classList.add('open');
        backdrop.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.remove('open');
        backdrop.classList.remove('open');
        document.body.style.overflow = '';
    }

    function loadCard(idx) {
        const card = lbPool[idx];
        if (!card) return;

        const src   = card.dataset.img   || card.querySelector('img')?.src;
        const title = card.dataset.title || '';
        const desc  = card.dataset.desc  || '';

        lbImgWrap.classList.add('loading');
        lbTitle.textContent = title;
        lbDesc.textContent  = desc;

        const tmp   = new Image();
        tmp.onload  = () => { lbImg.src = src; lbImg.alt = title; lbImgWrap.classList.remove('loading'); };
        tmp.onerror = () => lbImgWrap.classList.remove('loading');
        tmp.src     = src;
    }

    // Open on card click — each track is its own pool
    document.querySelectorAll('.gl-track').forEach(track => {
        const cards = Array.from(track.querySelectorAll('.gl-card'));
        track.addEventListener('click', e => {
            const card = e.target.closest('.gl-card');
            if (!card) return;
            openLightbox(card, cards);
        });
    });

    // Close
    lbClose.addEventListener('click', closeLightbox);
    backdrop.addEventListener('click', closeLightbox);

    // Prev / Next
    const goPrev = () => { lbIndex = (lbIndex - 1 + lbPool.length) % lbPool.length; loadCard(lbIndex); };
    const goNext = () => { lbIndex = (lbIndex + 1) % lbPool.length; loadCard(lbIndex); };
    lbPrev.addEventListener('click', goPrev);
    lbNext.addEventListener('click', goNext);

    // Keyboard
    document.addEventListener('keydown', e => {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape')     closeLightbox();
        if (e.key === 'ArrowRight') goPrev();
        if (e.key === 'ArrowLeft')  goNext();
    });

    // Touch swipe on lightbox
    let tX = null;
    lightbox.addEventListener('touchstart', e => { tX = e.touches[0].clientX; }, { passive: true });
    lightbox.addEventListener('touchend',   e => {
        if (tX === null) return;
        const diff = tX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) diff > 0 ? goNext() : goPrev();
        tX = null;
    }, { passive: true });

});
