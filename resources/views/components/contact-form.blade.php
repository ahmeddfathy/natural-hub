@props([
    'showHeader' => true,
    'headerTitle' => 'أرسل لنا رسالة',
    'headerSubtitle' => 'املأ النموذج أدناه وسنتواصل معك في أقرب وقت',
    'showQuickContact' => true,
    'showContactInfo' => true,
    'contactInfoTitle' => 'معلومات التواصل',
    'contactInfoSubtitle' => 'يمكنك التواصل معنا من خلال الطرق التالية',
    'formId' => 'contactForm',
    'containerClass' => '',
    'sectionTitle' => null,
    'sectionSubtitle' => null
])

<section class="contact-form-section {{ $containerClass }}">
    <div class="container">
        @if($sectionTitle)
        <div class="section-title-header">
            <h2>{{ $sectionTitle }}</h2>
            @if($sectionSubtitle)
            <p>{{ $sectionSubtitle }}</p>
            @endif
        </div>
        @endif

        <div class="contact-section-content {{ $showContactInfo ? 'with-info' : 'form-only' }}">
            {{-- Contact Info Section --}}
            @if($showContactInfo)
            <div class="contact-info-side">
                <div class="contact-info-header">
                    <h2>{{ $contactInfoTitle }}</h2>
                    <p>{{ $contactInfoSubtitle }}</p>
                </div>
                
                <div class="contact-info-cards">
                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>الهاتف</h3>
                            <a href="tel:+966502577777" dir="ltr" style="color: inherit; text-decoration: none;">+966 50 257 7777</a>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fab fa-twitter"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>تويتر (X)</h3>
                            <a href="https://x.com/olayanss" target="_blank" style="color: inherit; text-decoration: none;">@olayanss</a>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-card-icon">
                            <i class="fab fa-snapchat"></i>
                        </div>
                        <div class="contact-card-content">
                            <h3>سناب شات</h3>
                            <a href="https://snapchat.com/add/olayansss" target="_blank" style="color: inherit; text-decoration: none;">olayansss</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Contact Form Side --}}
            <div class="contact-form-side">
                <div class="form-container">
                    @if($showHeader)
                    <div class="form-header">
                        <h2>{{ $headerTitle }}</h2>
                        <p>{{ $headerSubtitle }}</p>
                    </div>
                    @endif
                    
                    <form class="contact-form" id="{{ $formId }}">
                        <div class="form-group">
                            <label for="{{ $formId }}_name">الاسم</label>
                            <input type="text" id="{{ $formId }}_name" name="name" required />
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="{{ $formId }}_email">البريد الإلكتروني</label>
                                <input type="email" id="{{ $formId }}_email" name="email" required />
                            </div>
                            <div class="form-group">
                                <label for="{{ $formId }}_phone">رقم الهاتف</label>
                                <input type="tel" id="{{ $formId }}_phone" name="phone" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="{{ $formId }}_company">اسم الشركة (اختياري)</label>
                            <input type="text" id="{{ $formId }}_company" name="company" />
                        </div>

                        <div class="form-group">
                            <label for="{{ $formId }}_service">نوع الخدمة المطلوبة</label>
                            <select id="{{ $formId }}_service" name="service">
                                <option value="">اختر نوع الخدمة</option>
                                <option value="feasibility">دراسة جدوى شاملة</option>
                                <option value="financial">دراسة جدوى مالية</option>
                                <option value="technical">دراسة جدوى فنية</option>
                                <option value="marketing">دراسة جدوى تسويقية</option>
                                <option value="production">خطوط الإنتاج</option>
                                <option value="competitor">تحليل المنافسين</option>
                                <option value="business">نماذج الأعمال</option>
                                <option value="investment">تقييم الفرص الاستثمارية</option>
                                <option value="market">تحليل السوق</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="{{ $formId }}_budget">الميزانية المتوقعة للمشروع</label>
                            <select id="{{ $formId }}_budget" name="budget">
                                <option value="">اختر الميزانية</option>
                                <option value="under-100k">أقل من 100,000 ريال</option>
                                <option value="100k-500k">100,000 - 500,000 ريال</option>
                                <option value="500k-1m">500,000 - 1,000,000 ريال</option>
                                <option value="1m-5m">1,000,000 - 5,000,000 ريال</option>
                                <option value="over-5m">أكثر من 5,000,000 ريال</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="{{ $formId }}_message">تفاصيل المشروع</label>
                            <textarea id="{{ $formId }}_message" name="message" rows="6" placeholder="اكتب تفاصيل مشروعك وأهدافك الاستثمارية..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane"></i>
                            إرسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if($showQuickContact)
        <div class="quick-contact-bar">
            <div class="quick-contact-content">
                <div class="quick-contact-text">
                    <h3>هل تحتاج إلى استشارة سريعة؟</h3>
                    <p>تواصل معنا مباشرة عبر الواتساب أو الهاتف للحصول على استشارة فورية</p>
                </div>
                <div class="quick-contact-buttons">
                    <a href="https://wa.me/966502577777" class="btn btn-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        واتساب
                    </a>
                    <a href="tel:+966502577777" class="btn btn-call">
                        <i class="fas fa-phone"></i>
                        اتصل الآن
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>

<script>
(function() {
    const formId = '{{ $formId }}';
    const form = document.getElementById(formId);
    
    // Prevent duplicate initialization
    if (!form || form.dataset.initialized === 'true') {
        return;
    }
    form.dataset.initialized = 'true';
    
    let isSubmitting = false;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Prevent double submission
        if (isSubmitting) {
            return;
        }
        isSubmitting = true;
        
        // Get form data BEFORE any changes
        const formData = new FormData(this);
        
        // Get submit button
        const submitBtn = this.querySelector('.btn-submit');
        const originalText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
        submitBtn.disabled = true;
        
        // Clear previous errors
        this.querySelectorAll('.form-error').forEach(el => el.remove());
        this.querySelectorAll('.form-group').forEach(el => el.classList.remove('has-error'));
        
        try {
            const response = await fetch('{{ route("contact.submit") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            });
            
            const result = await response.json();
            
            if (response.ok && result.success) {
                // Success - show success message
                showNotification('success', result.message || 'تم إرسال رسالتك بنجاح!');
                form.reset();
            } else if (response.status === 422) {
                // Validation errors
                if (result.errors) {
                    Object.keys(result.errors).forEach(field => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            const formGroup = input.closest('.form-group');
                            if (formGroup) {
                                formGroup.classList.add('has-error');
                                
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'form-error';
                                errorDiv.style.cssText = 'color: #dc3545; font-size: 12px; margin-top: 5px;';
                                errorDiv.textContent = result.errors[field][0];
                                formGroup.appendChild(errorDiv);
                            }
                        }
                    });
                }
                showNotification('error', 'يرجى تصحيح الأخطاء في النموذج');
            } else {
                // Server error
                showNotification('error', result.message || 'حدث خطأ أثناء إرسال الرسالة');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            showNotification('error', 'حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
        } finally {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            isSubmitting = false;
        }
    });
    
    // Notification function
    function showNotification(type, message) {
        // Remove existing notification
        const existingNotification = document.querySelector('.contact-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        const notification = document.createElement('div');
        notification.className = `contact-notification ${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            animation: slideIn 0.3s ease;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        `;
        
        if (type === 'success') {
            notification.style.backgroundColor = '#28a745';
            notification.innerHTML = '<i class="fas fa-check-circle"></i> ' + message;
        } else {
            notification.style.backgroundColor = '#dc3545';
            notification.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + message;
        }
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }
    
    // Add animation styles
    if (!document.querySelector('#contact-notification-styles')) {
        const style = document.createElement('style');
        style.id = 'contact-notification-styles';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }
})();
</script>
