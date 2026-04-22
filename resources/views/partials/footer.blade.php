{{-- ===== FOOTER ===== --}}
<footer class="footer-clean" id="contact">
    <div class="container">
        {{-- Top Bar --}}
        <div class="ft-top">
            <div class="ft-logo">
                <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Natural Hub" class="site-logo-ft">
            </div>
            <div class="ft-social-circles">
                <a href="https://www.facebook.com/NaturalHubSkincare" class="soc-icon fb" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="soc-icon tw"><i class="fab fa-twitter"></i></a>
                <a href="#" class="soc-icon pi"><i class="fab fa-pinterest-p"></i></a>
                <a href="#" class="soc-icon in"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        {{-- Middle 3 Columns --}}
        <div class="ft-mid">
            {{-- Col 1: About --}}
            <div class="ft-col ft-col-about">
                <h3>من نحن</h3>
                <p>صالون وسبا المنتجات الطبيعية الأفضل، يقدم أحدث خدمات العناية بالشعر والبشرة. نحن نؤمن بأن جمالك الطبيعي يستحق عناية فائقة في بيئة مريحة وهادئة للوصول إلى أعلى درجات الاسترخاء.</p>
            </div>

            {{-- Col 2: Contact --}}
            <div class="ft-col ft-col-contact">
                <h3>تواصل معنا</h3>
                <ul>
                    <li>
                        <div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>
                        <span>محرم بك، الإسكندرية، مصر<br>بجوار نادي الصيد</span>
                    </li>
                    <li>
                        <div class="icon-circle"><i class="fas fa-envelope"></i></div>
                        <span>support@naturalhub.com</span>
                    </li>
                    <li>
                        <div class="icon-circle"><i class="fas fa-mobile-alt"></i></div>
                        <span dir="ltr">+20 100 123 4567</span>
                    </li>
                </ul>
            </div>

            {{-- Col 3: Hours --}}
            <div class="ft-col ft-col-hours">
                <h3>ساعات العمل</h3>
                <div class="hours-row">
                    <span>السبت - الخميس:</span>
                    <strong>10ص - 10م</strong>
                </div>
                <div class="hours-row">
                    <span>الجمعة:</span>
                    <strong>1م - 10م</strong>
                </div>
                <a href="{{ url('/contact') }}" class="ft-book-link">احجزي موعدك</a>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="ft-bottom-copy">
            <p>Copyright © {{ date('Y') }}, NaturalHub Powered by Web Master.</p>
        </div>
    </div>
</footer>

{{-- ===== STICKY WHATSAPP ===== --}}
<a href="https://wa.me/201001234567" class="wa-float" target="_blank" aria-label="تواصلي عبر واتساب" id="waFloat">
    <i class="fab fa-whatsapp"></i>
    <span class="wa-pulse"></span>
</a>

{{-- ===== BACK TO TOP ===== --}}
<button class="btt" id="btt" aria-label="العودة للأعلى"><i class="fas fa-chevron-up"></i></button>
