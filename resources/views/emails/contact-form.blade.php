<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رسالة جديدة من نموذج التواصل</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.8;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a8e 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .email-body {
            padding: 30px;
        }
        .info-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-section h2 {
            color: #1e3a5f;
            font-size: 18px;
            margin: 0 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }
        .info-label {
            font-weight: 600;
            color: #1e3a5f;
            min-width: 140px;
        }
        .info-value {
            color: #495057;
            flex: 1;
        }
        .message-section {
            background-color: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 20px;
        }
        .message-section h2 {
            color: #1e3a5f;
            font-size: 18px;
            margin: 0 0 15px;
        }
        .message-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .email-footer p {
            margin: 0;
            color: #6c757d;
            font-size: 13px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
        }
        .badge-service {
            background-color: #e3f2fd;
            color: #1565c0;
        }
        .badge-budget {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📩 رسالة جديدة من نموذج التواصل</h1>
            <p>تم استلام رسالة جديدة من موقع دراسات الجدوى</p>
        </div>
        
        <div class="email-body">
            <div class="info-section">
                <h2>👤 معلومات المرسل</h2>
                
                <div class="info-row">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $data['name'] }}</span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">البريد الإلكتروني:</span>
                    <span class="info-value"><a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a></span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">رقم الهاتف:</span>
                    <span class="info-value"><a href="tel:{{ $data['phone'] }}">{{ $data['phone'] }}</a></span>
                </div>
                
                @if(!empty($data['company']))
                <div class="info-row">
                    <span class="info-label">اسم الشركة:</span>
                    <span class="info-value">{{ $data['company'] }}</span>
                </div>
                @endif
            </div>
            
            <div class="info-section">
                <h2>📋 تفاصيل الطلب</h2>
                
                <div class="info-row">
                    <span class="info-label">نوع الخدمة:</span>
                    <span class="info-value">
                        <span class="badge badge-service">{{ $data['service_label'] }}</span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="info-label">الميزانية المتوقعة:</span>
                    <span class="info-value">
                        <span class="badge badge-budget">{{ $data['budget_label'] }}</span>
                    </span>
                </div>
            </div>
            
            <div class="message-section">
                <h2>💬 تفاصيل المشروع</h2>
                <div class="message-content">{{ $data['message'] }}</div>
            </div>
        </div>
        
        <div class="email-footer">
            <p>تم إرسال هذه الرسالة من موقع دراسات الجدوى في {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
