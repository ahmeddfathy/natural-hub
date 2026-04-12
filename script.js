/* =============================================
   NATURAL HUB — Homepage Interactions
   ============================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Navbar scroll ── */
    const navbar = document.getElementById('navbar');
    const btt = document.getElementById('btt');

    const onScroll = () => {
        const y = window.scrollY;
        navbar.classList.toggle('scrolled', y > 60);
        btt.classList.toggle('show', y > 500);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* ── Mobile menu ── */
    const burger = document.getElementById('burger');
    const navMenu = document.getElementById('navMenu');
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
        document.body.style.overflow = 'hidden';
    };

    const closeNav = () => {
        navMenu.classList.remove('on');
        burger.classList.remove('open');
        if (overlay) overlay.classList.remove('on');
        document.body.style.overflow = '';
    };

    burger.addEventListener('click', () => navMenu.classList.contains('on') ? closeNav() : openNav());
    navMenu.querySelectorAll('a').forEach(a => a.addEventListener('click', closeNav));

    /* ── Smooth scroll ── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function (e) {
            const id = this.getAttribute('href');
            if (id === '#') return;
            const el = document.querySelector(id);
            if (el) {
                e.preventDefault();
                const top = el.getBoundingClientRect().top + window.scrollY - navbar.offsetHeight - 16;
                window.scrollTo({ top, behavior: 'smooth' });
            }
        });
    });

    /* ── Scroll reveal ── */
    const revealEls = document.querySelectorAll(
        '.why-card, .srv-card, .ba-card, .gal-card, .rev-card, .sec-head, .book-content, .book-map, .cta-band-inner'
    );

    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.d || 0;
                setTimeout(() => entry.target.classList.add('vis'), delay);
                revealObs.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -40px 0px', threshold: 0.08 });

    revealEls.forEach((el, i) => {
        el.classList.add('reveal');
        // stagger siblings
        const parent = el.parentElement;
        if (parent) {
            const sibs = Array.from(parent.children).filter(c => revealEls instanceof NodeList ? 
                Array.from(revealEls).includes(c) : false);
            const idx = sibs.indexOf(el);
            if (idx > 0) el.dataset.d = idx * 100;
        }
        revealObs.observe(el);
    });

    /* ── Swipe carousel enhanced touch ── */
    const tracks = document.querySelectorAll('.swipe-track');

    tracks.forEach(track => {
        let isDown = false, startX, scrollLeft;

        track.addEventListener('mousedown', (e) => {
            isDown = true;
            track.style.cursor = 'grabbing';
            startX = e.pageX - track.offsetLeft;
            scrollLeft = track.scrollLeft;
        });

        track.addEventListener('mouseleave', () => { isDown = false; track.style.cursor = 'grab'; });
        track.addEventListener('mouseup', () => { isDown = false; track.style.cursor = 'grab'; });

        track.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 1.5;
            track.scrollLeft = scrollLeft - walk;
        });
    });

    /* ── Counter animation ── */
    const counters = document.querySelectorAll('.trust-badge span');
    let counted = false;

    const animateNum = (el) => {
        const raw = el.textContent;
        const match = raw.match(/\d+/);
        if (!match) return;
        const target = parseInt(match[0]);
        const prefix = raw.slice(0, raw.indexOf(match[0]));
        const suffix = raw.slice(raw.indexOf(match[0]) + match[0].length);
        let cur = 0;
        const inc = Math.ceil(target / 50);
        const step = setInterval(() => {
            cur += inc;
            if (cur >= target) { cur = target; clearInterval(step); }
            el.textContent = prefix + cur.toLocaleString('ar-EG') + suffix;
        }, 35);
    };

    const trustRow = document.querySelector('.trust-row');
    if (trustRow) {
        const cObs = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !counted) {
                counted = true;
                // Keep original text (don't animate Arabic text, just pulse effect)
                trustRow.querySelectorAll('.trust-badge').forEach((badge, i) => {
                    setTimeout(() => badge.style.animation = 'fadeUp .5s ease-out forwards', i * 150);
                });
            }
        }, { threshold: 0.5 });
        cObs.observe(trustRow);
    }

    /* ── Active nav link ── */
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-menu a');

    const activeObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                navLinks.forEach(link => {
                    link.style.color = '';
                    if (link.getAttribute('href') === `#${id}`) {
                        link.style.color = 'var(--gold)';
                    }
                });
            }
        });
    }, { root: null, rootMargin: '-25% 0px -75% 0px', threshold: 0 });

    sections.forEach(s => activeObs.observe(s));

    /* ── Parallax tilt on service cards (desktop) ── */
    if (window.matchMedia('(min-width:768px)').matches) {
        document.querySelectorAll('.srv-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const r = card.getBoundingClientRect();
                const x = e.clientX - r.left;
                const y = e.clientY - r.top;
                const rx = (y - r.height / 2) / 25;
                const ry = (r.width / 2 - x) / 25;
                card.style.transform = `perspective(800px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-4px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    }

});
