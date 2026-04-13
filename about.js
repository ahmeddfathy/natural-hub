/* =============================================
   NATURAL HUB — About Page Interactions
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
        '.value-card, .team-card, .journey-card, .rev-card, .sec-head, .story-img-wrap, .story-text, .milestone-item'
    );

    const revealObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.d || 0;
                setTimeout(() => entry.target.classList.add('vis'), parseInt(delay));
                revealObs.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -40px 0px', threshold: 0.08 });

    revealEls.forEach((el) => {
        el.classList.add('reveal');
        revealObs.observe(el);
    });

    /* ── Milestone counter animation ── */
    const milestoneItems = document.querySelectorAll('.milestone-item');
    let counted = false;

    const animateCount = (el) => {
        const countEl = el.querySelector('.milestone-count');
        if (!countEl) return;
        const target = parseInt(countEl.dataset.target);
        let current = 0;
        const duration = 1800;
        const increment = target / (duration / 16);

        const step = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(step);
            }
            countEl.textContent = Math.floor(current).toLocaleString('ar-EG');
        }, 16);
    };

    const milestonesSection = document.querySelector('.about-milestones');
    if (milestonesSection) {
        const cObs = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting && !counted) {
                counted = true;
                milestoneItems.forEach((item, i) => {
                    setTimeout(() => animateCount(item), i * 150);
                });
            }
        }, { threshold: 0.4 });
        cObs.observe(milestonesSection);
    }

    /* ── Parallax on hero ── */
    const heroImg = document.querySelector('.about-hero-img');
    if (heroImg && window.matchMedia('(min-width: 768px)').matches) {
        window.addEventListener('scroll', () => {
            const scrolled = window.scrollY;
            heroImg.style.transform = `translateY(${scrolled * 0.3}px)`;
        }, { passive: true });
    }

    /* ── Team card 3D tilt (desktop) ── */
    if (window.matchMedia('(min-width:768px)').matches) {
        document.querySelectorAll('.team-card, .value-card').forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const r = card.getBoundingClientRect();
                const x = e.clientX - r.left;
                const y = e.clientY - r.top;
                const rx = (y - r.height / 2) / 30;
                const ry = (r.width / 2 - x) / 30;
                card.style.transform = `perspective(900px) rotateX(${rx}deg) rotateY(${ry}deg) translateY(-6px)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    }

    /* ── Journey items stagger on scroll ── */
    const journeyItems = document.querySelectorAll('.journey-item');
    const journeyObs = new IntersectionObserver((entries) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setTimeout(() => entry.target.classList.add('vis'), i * 120);
                journeyObs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });

    journeyItems.forEach(item => {
        item.classList.add('reveal');
        journeyObs.observe(item);
    });

});
