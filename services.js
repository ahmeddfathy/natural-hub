/* =============================================
   NATURAL HUB — Services Page JavaScript
   ============================================= */

(function () {
    'use strict';

    /* ════════════════════════════════
       NAVBAR + SCROLL TO TOP
    ════════════════════════════════ */
    const navbar = document.getElementById('navbar');
    const btt    = document.getElementById('btt');
    const waFloat = document.getElementById('waFloat');
    const tabsBar = document.getElementById('srvTabsBar');

    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        
        // Navbar styling
        if (navbar) navbar.classList.toggle('scrolled', y > 60);
        
        // Buttons visibility
        if (btt) btt.classList.toggle('visible', y > 400);
        if (waFloat) waFloat.classList.toggle('visible', y > 200);

        // Sticky tabs style tweak if needed when scrolling
        if (tabsBar) {
            tabsBar.classList.toggle('sticking', y > 400);
            updateActiveTabOnScroll();
        }

    }, { passive: true });

    if (btt) {
        btt.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    /* ════════════════════════════════
       BURGER MENU
    ════════════════════════════════ */
    const burger  = document.getElementById('burger');
    const navMenu = document.getElementById('navMenu');

    if (burger && navMenu) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('open');
            navMenu.classList.toggle('on');
        });

        navMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                burger.classList.remove('open');
                navMenu.classList.remove('on');
            });
        });
    }

    /* ════════════════════════════════
       TABS NAVIGATION (SCROLL TO SECTION)
    ════════════════════════════════ */
    const tabs = document.querySelectorAll('.srv-tab');
    const sections = document.querySelectorAll('.srv-cat');
    let isClickScrolling = false;

    if (tabs.length > 0) {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetId = tab.getAttribute('data-target');
                const targetSec = document.getElementById(targetId);
                
                if (targetSec) {
                    isClickScrolling = true;
                    
                    // Update active tab style immediately
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    // Calculate offset (navbar height + tabs bar height)
                    const navHeight = navbar ? navbar.offsetHeight : 0;
                    const tabsHeight = tabsBar ? tabsBar.offsetHeight : 0;
                    const offset = navHeight + tabsHeight - 10; // Extra 10px buffer

                    const targetY = targetSec.getBoundingClientRect().top + window.scrollY - offset;

                    window.scrollTo({
                        top: targetY,
                        behavior: 'smooth'
                    });

                    // Resume scroll tracking after animation
                    setTimeout(() => {
                        isClickScrolling = false;
                    }, 800);
                }
            });
        });
    }

    /* ════════════════════════════════
       UPDATE ACTIVE TAB ON SCROLL
    ════════════════════════════════ */
    function updateActiveTabOnScroll() {
        if (isClickScrolling || !sections.length || !tabs.length) return;

        let currentActiveId = '';
        const navHeight = navbar ? navbar.offsetHeight : 0;
        const tabsHeight = tabsBar ? tabsBar.offsetHeight : 0;
        const offset = navHeight + tabsHeight + 100; // Trigger slightly earlier

        sections.forEach(sec => {
            const secTop = sec.getBoundingClientRect().top + window.scrollY;
            if (window.scrollY >= secTop - offset) {
                currentActiveId = sec.getAttribute('id');
            }
        });

        if (currentActiveId) {
            tabs.forEach(tab => {
                if (tab.getAttribute('data-target') === currentActiveId) {
                    if (!tab.classList.contains('active')) {
                        tabs.forEach(t => t.classList.remove('active'));
                        tab.classList.add('active');
                        // Optional: gently scroll tabs container to keep active tab visible on mobile
                        if (tabsBar) {
                            const inner = tabsBar.querySelector('.srv-tabs-inner');
                            if (inner) {
                                inner.scrollTo({
                                    left: tab.offsetLeft - 20,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    }
                }
            });
        }
    }

    /* ════════════════════════════════
       REVEAL ANIMATIONS ON SCROLL
    ════════════════════════════════ */
    const revealEls = document.querySelectorAll(
        '.srv-hero-card, .srv-card, .srv-bridal-card, .srv-cat-head'
    );

    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry, idx) => {
                if (entry.isIntersecting) {
                    // Stagger effect based on grid layout approximation
                    const delay = (idx % 3) * 100; 
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, delay);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        revealEls.forEach(el => revealObserver.observe(el));
    } else {
        // Fallback for older browsers
        revealEls.forEach(el => el.classList.add('visible'));
    }

    /* ════════════════════════════════
       SMOOTH SCROLL for basic anchor links
    ════════════════════════════════ */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const targetId = a.getAttribute('href');
            if (targetId === '#') return; // Skip empty
            
            const target = document.querySelector(targetId);
            if (target && !a.classList.contains('srv-tab')) {
                e.preventDefault();
                
                const navHeight = navbar ? navbar.offsetHeight : 0;
                // Only add tabs bar offset if target is inside the main grid
                const tabsHeight = target.closest('.srv-main') && tabsBar ? tabsBar.offsetHeight : 0;
                
                const targetY = target.getBoundingClientRect().top + window.scrollY - (navHeight + tabsHeight);
                
                window.scrollTo({ 
                    top: targetY, 
                    behavior: 'smooth' 
                });
            }
        });
    });

})();
