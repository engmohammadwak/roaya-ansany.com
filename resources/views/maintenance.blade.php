<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ App\Models\Setting::get('site_name', 'الموقع') }} - تحت الصيانة</title>
    @php
        $favicon  = App\Models\Setting::get('site_favicon');
        $logo     = App\Models\Setting::get('site_logo');
        $phone1   = App\Models\Setting::get('contact_phone');
        $phone2   = App\Models\Setting::get('contact_phone_2');
        $phone3   = App\Models\Setting::get('contact_phone_3');
        $email1   = App\Models\Setting::get('contact_email');
        $email2   = App\Models\Setting::get('contact_email_2');
        $email3   = App\Models\Setting::get('contact_email_3');
        $wa1      = App\Models\Setting::get('whatsapp_number');
        $wa2      = App\Models\Setting::get('whatsapp_number_2');
        $wa3      = App\Models\Setting::get('whatsapp_number_3');
        $fb       = App\Models\Setting::get('social_facebook');
        $ig       = App\Models\Setting::get('social_instagram');
        $tw       = App\Models\Setting::get('social_twitter');
        $waLink   = App\Models\Setting::get('social_whatsapp');
        $primary  = App\Models\Setting::get('color_primary', '#C4452C');
    @endphp
    @if($favicon)
        <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Cairo', sans-serif;
            background: #f8f5f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 24px;
            padding: 50px 40px;
            max-width: 520px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
        }
        .logo { max-height: 70px; margin-bottom: 30px; }
        .icon { font-size: 64px; margin-bottom: 20px; }
        h1 { font-size: 28px; font-weight: 800; color: #1E2A32; margin-bottom: 12px; }
        p { color: #6B7A7F; font-size: 15px; line-height: 1.8; margin-bottom: 30px; }
        .divider { border: none; border-top: 1px solid #eee; margin: 24px 0; }
        .contact-section { text-align: right; margin-bottom: 20px; }
        .contact-section h3 { font-size: 14px; font-weight: 700; color: #1E2A32; margin-bottom: 10px; }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 10px;
            background: #f8f5f0;
            margin-bottom: 8px;
            font-size: 14px;
            color: #1E2A32;
            text-decoration: none;
            transition: background 0.2s;
        }
        .contact-item:hover { background: #eee; }
        .social-row {
            display: flex;
            justify-content: center;
            gap: 14px;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        .social-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            transition: opacity 0.2s;
        }
        .social-btn:hover { opacity: 0.85; }
        .btn-fb { background: #1877F2; }
        .btn-ig { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); }
        .btn-tw { background: #000; }
        .btn-wa { background: #25D366; }
    </style>
</head>
<body>
<div class="card">
    @if($logo)
        <img src="{{ asset('storage/' . $logo) }}" alt="logo" class="logo">
    @else
        <div class="icon">🔧</div>
    @endif

    <h1>الموقع تحت الصيانة</h1>
    <p>نعمل على تحسين تجربتكم. سنعود قريباً بشكل أفضل.<br>شكراً لتفهمكم 🙏</p>

    @if($phone1 || $phone2 || $phone3 || $email1 || $email2 || $email3 || $wa1 || $wa2 || $wa3)
    <hr class="divider">
    <div class="contact-section">
        <h3>📞 للتواصل معنا</h3>
        @foreach([[$phone1,'tel'], [$phone2,'tel'], [$phone3,'tel']] as $p)
            @if($p[0])
                <a href="tel:{{ $p[0] }}" class="contact-item">📱 {{ $p[0] }}</a>
            @endif
        @endforeach
        @foreach([[$email1,'mailto'], [$email2,'mailto'], [$email3,'mailto']] as $e)
            @if($e[0])
                <a href="mailto:{{ $e[0] }}" class="contact-item">✉️ {{ $e[0] }}</a>
            @endif
        @endforeach
        @foreach([[$wa1,'whatsapp_text_1'], [$wa2,'whatsapp_text_2'], [$wa3,'whatsapp_text_3']] as $w)
            @if($w[0])
                @php $txt = App\Models\Setting::get($w[1]); @endphp
                <a href="https://wa.me/{{ $w[0] }}{{ $txt ? '?text=' . urlencode($txt) : '' }}" target="_blank" class="contact-item">💬 واتساب: {{ $w[0] }}</a>
            @endif
        @endforeach
    </div>
    @endif

    @if($fb || $ig || $tw || $waLink)
    <div class="social-row">
        @if($fb) <a href="{{ $fb }}" target="_blank" class="social-btn btn-fb">f Facebook</a> @endif
        @if($ig) <a href="{{ $ig }}" target="_blank" class="social-btn btn-ig">📷 Instagram</a> @endif
        @if($tw) <a href="{{ $tw }}" target="_blank" class="social-btn btn-tw">𝕏 Twitter</a> @endif
        @if($waLink) <a href="{{ $waLink }}" target="_blank" class="social-btn btn-wa">💬 WhatsApp</a> @endif
    </div>
    @endif
</div>
</body>
</html>
