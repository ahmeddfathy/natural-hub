/* =============================================
   NATURAL HUB — Videos Page Script
   Same pattern as gallery.js
   ============================================= */

(function () {
    'use strict';

    /* ────────────────────────────
       NAVBAR SCROLL + BTT
    ──────────────────────────── */
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
        navMenu.querySelectorAll('li > a').forEach(a => {
            a.addEventListener('click', () => {
                closeNav();
            });
        });
    }

    /* ────────────────────────────
       ARROW NAVIGATION — same as gallery.js
    ──────────────────────────── */
    const SCROLL_AMOUNT = 296; // card width (260) + gap (16) * 2

    document.querySelectorAll('.vd-arrow').forEach(btn => {
        btn.addEventListener('click', () => {
            const trackId = btn.dataset.track;
            const track   = document.getElementById('track-' + trackId);
            if (!track) return;

            const dir = btn.classList.contains('vd-arrow-prev') ? 1 : -1;
            track.scrollBy({ left: dir * SCROLL_AMOUNT, behavior: 'smooth' });
        });
    });

    /* ────────────────────────────
       DRAG TO SCROLL — same as gallery.js
    ──────────────────────────── */
    document.querySelectorAll('.vd-track').forEach(track => {
        let isDown = false;
        let startX, scrollLeft;

        track.addEventListener('mousedown', e => {
            isDown = true;
            track.classList.add('grabbing');
            startX     = e.pageX - track.offsetLeft;
            scrollLeft = track.scrollLeft;
        });

        document.addEventListener('mouseup', () => {
            isDown = false;
            track.classList.remove('grabbing');
        });

        track.addEventListener('mouseleave', () => {
            isDown = false;
            track.classList.remove('grabbing');
        });

        track.addEventListener('mousemove', e => {
            if (!isDown) return;
            e.preventDefault();
            const x    = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 1.4;
            track.scrollLeft = scrollLeft - walk;
        });

        /* Touch support */
        let touchStartX, touchScrollLeft;

        track.addEventListener('touchstart', e => {
            touchStartX    = e.touches[0].pageX;
            touchScrollLeft = track.scrollLeft;
        }, { passive: true });

        track.addEventListener('touchmove', e => {
            const diff = touchStartX - e.touches[0].pageX;
            track.scrollLeft = touchScrollLeft + diff;
        }, { passive: true });
    });

    /* ────────────────────────────
       ENABLE IFRAME ON CLICK
       (pointer-events: none while scrolling, enabled on click)
    ──────────────────────────── */
    document.querySelectorAll('.vd-card').forEach(card => {
        card.addEventListener('click', () => {
            const iframe = card.querySelector('iframe');
            if (iframe) {
                iframe.style.pointerEvents = 'auto';
                // Reset pointer-events after 5 seconds
                setTimeout(() => {
                    iframe.style.pointerEvents = '';
                }, 5000);
            }
        });
    });

})();
