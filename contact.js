/* =============================================
   NATURAL HUB — Contact Page Script
   ============================================= */

(function () {
    'use strict';

    /* ────────────────────────────
       NAVBAR SCROLL BEHAVIOUR
    ──────────────────────────── */
    const navbar = document.getElementById('navbar');
    const btt    = document.getElementById('btt');
    const waFloat = document.getElementById('waFloat');

    window.addEventListener('scroll', () => {
        const y = window.scrollY;
        if (navbar) navbar.classList.toggle('scrolled', y > 60);
        if (btt)    btt.classList.toggle('visible',   y > 400);
        if (waFloat) waFloat.classList.toggle('visible', y > 200);
    }, { passive: true });

    if (btt) btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

    /* ────────────────────────────
       BURGER MENU
    ──────────────────────────── */
    const burger  = document.getElementById('burger');
    const navMenu = document.getElementById('navMenu');

    if (burger && navMenu) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('open');
            navMenu.classList.toggle('open');
        });

        navMenu.querySelectorAll('a').forEach(a => {
            a.addEventListener('click', () => {
                burger.classList.remove('open');
                navMenu.classList.remove('open');
            });
        });
    }

    /* ────────────────────────────
       OPEN / CLOSED BADGE
    ──────────────────────────── */
    function checkOpenStatus() {
        const badge  = document.getElementById('openNowBadge');
        const dot    = badge && badge.querySelector('.open-dot');
        const text   = document.getElementById('openNowText');
        if (!badge) return;

        const now    = new Date();
        const day    = now.getDay();   // 0 = Sun, 5 = Fri, 6 = Sat
        const hour   = now.getHours();
        const minute = now.getMinutes();
        const time   = hour + minute / 60;

        // Friday: 13:00 – 22:00  |  Sat–Thu: 10:00 – 22:00
        let opens = 10, closes = 22;
        if (day === 5) opens = 13;          // Friday
        // Sunday closed? We'll leave open all week per specs

        const isOpen = time >= opens && time < closes;

        badge.classList.toggle('closed', !isOpen);
        if (dot)  dot.style.background = isOpen ? '#25D366' : '#ef4444';
        if (text) text.textContent = isOpen ? 'مفتوح الآن' : 'مغلق حالياً';
    }

    checkOpenStatus();
    setInterval(checkOpenStatus, 60_000);

    /* ────────────────────────────
       SET MIN DATE FOR BOOKING
    ──────────────────────────── */
    const dateInput = document.getElementById('contactDate');
    if (dateInput) {
        const today = new Date();
        const yyyy  = today.getFullYear();
        const mm    = String(today.getMonth() + 1).padStart(2, '0');
        const dd    = String(today.getDate()).padStart(2, '0');
        dateInput.min = `${yyyy}-${mm}-${dd}`;
    }

    /* ────────────────────────────
       FORM VALIDATION + WHATSAPP
    ──────────────────────────── */
    const form       = document.getElementById('contactForm');
    const submitBtn  = document.getElementById('formSubmitBtn');
    const successBox = document.getElementById('formSuccess');

    function showError(groupId, errorId) {
        const g = document.getElementById(groupId);
        if (g) g.classList.add('has-error');
    }

    function clearError(groupId) {
        const g = document.getElementById(groupId);
        if (g) g.classList.remove('has-error');
    }

    // Live clear on input
    ['contactName', 'contactPhone', 'contactService', 'contactDate'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input', () => {
            const group = el.closest('.form-group');
            if (group) group.classList.remove('has-error');
        });
        el.addEventListener('change', () => {
            const group = el.closest('.form-group');
            if (group) group.classList.remove('has-error');
        });
    });

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const name    = document.getElementById('contactName')?.value.trim();
            const phone   = document.getElementById('contactPhone')?.value.trim();
            const service = document.getElementById('contactService')?.value;
            const date    = document.getElementById('contactDate')?.value;
            const time    = document.getElementById('contactTime')?.value;
            const message = document.getElementById('contactMessage')?.value.trim();

            let valid = true;

            // Name
            if (!name) { showError('nameGroup', 'nameError'); valid = false; }
            else clearError('nameGroup');

            // Phone
            const phoneClean = phone.replace(/\s+/g, '');
            if (!phone || !/^(01)[0-9]{9}$/.test(phoneClean)) {
                showError('phoneGroup', 'phoneError'); valid = false;
            } else clearError('phoneGroup');

            // Service
            if (!service) { showError('serviceGroup', 'serviceError'); valid = false; }
            else clearError('serviceGroup');

            // Date
            if (!date) { showError('dateGroup', 'dateError'); valid = false; }
            else clearError('dateGroup');

            if (!valid) {
                // Scroll to first error
                const firstErr = form.querySelector('.has-error input, .has-error select');
                if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }

            // Show loading
            const btnText    = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');
            submitBtn.disabled = true;
            btnText.style.display    = 'none';
            btnLoading.style.display = 'flex';

            // Service label map
            const serviceLabels = {
                hair:    'علاجات الشعر (بروتين / كيراتين)',
                skin:    'جلسات العناية بالبشرة',
                lashes:  'تركيب الرموش',
                bridal:  'باقة العروسة VIP',
                other:   'استفسار عام'
            };

            const serviceLabel = serviceLabels[service] || service;

            // Build WhatsApp message
            let waMsg = `مرحباً Natural Hub! 🌿\n\n`;
            waMsg += `اسمي: ${name}\n`;
            waMsg += `الجوال: ${phone}\n`;
            waMsg += `الخدمة المطلوبة: ${serviceLabel}\n`;
            if (date) waMsg += `التاريخ المفضل: ${formatDate(date)}\n`;
            if (time) waMsg += `الوقت المفضل: ${time}\n`;
            if (message) waMsg += `\nملاحظات إضافية:\n${message}`;

            const encoded = encodeURIComponent(waMsg);
            const waUrl   = `https://wa.me/201001234567?text=${encoded}`;

            // Simulate small delay then open WA
            setTimeout(() => {
                submitBtn.disabled = false;
                btnText.style.display    = 'flex';
                btnLoading.style.display = 'none';

                // Show success
                if (successBox) {
                    successBox.style.display = 'flex';
                    successBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }

                // Open WhatsApp
                window.open(waUrl, '_blank');

                // Reset form after a delay
                setTimeout(() => {
                    form.reset();
                    if (successBox) successBox.style.display = 'none';
                }, 8000);

            }, 1200);
        });
    }

    function formatDate(dateStr) {
        const d = new Date(dateStr + 'T00:00:00');
        return d.toLocaleDateString('ar-EG', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
    }

    /* ────────────────────────────
       FAQ ACCORDION
    ──────────────────────────── */
    const faqList = document.getElementById('faqList');
    if (faqList) {
        faqList.querySelectorAll('.faq-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.closest('.faq-item');
                const ans  = btn.nextElementSibling;
                const isOpen = item.classList.contains('open');

                // Close all
                faqList.querySelectorAll('.faq-item').forEach(it => {
                    it.classList.remove('open');
                    it.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
                    const a = it.querySelector('.faq-ans');
                    if (a) a.classList.remove('visible');
                });

                // Toggle clicked one
                if (!isOpen) {
                    item.classList.add('open');
                    btn.setAttribute('aria-expanded', 'true');
                    if (ans) ans.classList.add('visible');
                }
            });
        });
    }

    /* ────────────────────────────
       REVEAL ON SCROLL
    ──────────────────────────── */
    const revealEls = document.querySelectorAll('.reveal, .quick-card, .contact-info-card, .faq-item');

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, idx) => {
            if (entry.isIntersecting) {
                const delay = entry.target.dataset.d ? parseInt(entry.target.dataset.d) : 0;
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, delay);
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    revealEls.forEach((el, i) => {
        if (!el.classList.contains('reveal')) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(24px)';
            el.style.transition = `opacity 0.55s ease ${i * 80}ms, transform 0.55s ease ${i * 80}ms`;
        }
        revealObserver.observe(el);

        // Override visible to also handle inline style
        const origObserve = revealObserver;
    });

    // Handle quick-card and info-card reveal specifically
    document.querySelectorAll('.quick-card, .contact-info-card, .faq-item').forEach((el, i) => {
        el.style.transition = `opacity 0.5s ease ${i * 70}ms, transform 0.5s ease ${i * 70}ms, border-color 0.35s ease, box-shadow 0.35s ease`;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        observer.observe(el);
    });

    /* ────────────────────────────
       SMOOTH SCROLL for # links
    ──────────────────────────── */
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const target = document.querySelector(a.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

})();
