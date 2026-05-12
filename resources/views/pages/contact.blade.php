@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? 'اتصل بنا' : 'Contact Us') . ' | مؤسسة رؤيا الإنسانية')
@push('styles')
<style>
.contact-hero { background: linear-gradient(135deg,#1a7a4a,#2ecc71); padding:100px 0 60px; color:#fff; text-align:center; }
.contact-hero h1 { font-size:2.5rem; font-weight:700; }
.contact-hero p { font-size:1.1rem; opacity:.9; max-width:600px; margin:10px auto 0; }
.contact-section { padding:70px 0; background:#fff; }
.info-card { background:#f8fffe; border-radius:16px; padding:30px 25px; text-align:center; height:100%; border-bottom:3px solid #1a7a4a; }
.info-card .ic-icon { font-size:2.2rem; margin-bottom:12px; }
.info-card h5 { font-weight:700; color:#1a7a4a; margin-bottom:8px; }
.info-card p, .info-card a { color:#555; text-decoration:none; font-size:.95rem; }
.form-card { background:#fff; border-radius:20px; padding:40px; box-shadow:0 8px 40px rgba(0,0,0,.08); }
.form-card .form-label { font-weight:600; color:#333; }
.form-card .form-control { border-radius:10px; border:1px solid #ddd; padding:12px 15px; }
.form-card .form-control:focus { border-color:#1a7a4a; box-shadow:0 0 0 3px rgba(26,122,74,.1); }
.btn-send { background:#1a7a4a; color:#fff; padding:13px 40px; border-radius:50px; font-weight:700; border:none; width:100%; font-size:1rem; transition:all .3s; }
.btn-send:hover { background:#15623b; transform:translateY(-2px); }
.social-links a { display:inline-flex; align-items:center; justify-content:center; width:42px; height:42px; border-radius:50%; background:#1a7a4a; color:#fff; margin:0 5px; text-decoration:none; font-size:1.1rem; transition:all .3s; }
.social-links a:hover { background:#15623b; transform:translateY(-3px); }
.breadcrumb-section { background:#f0faf5; padding:12px 0; border-bottom:1px solid #d4edda; }
.breadcrumb-section a { color:#1a7a4a; text-decoration:none; }
</style>
@endpush
@section('content')
<div class="breadcrumb-section">
    <div class="container"><small><a href="{{ url($locale.'/') }}">{{ $isAr?'الرئيسية':'Home' }}</a><span style="margin:0 8px;color:#888">›</span><span class="text-muted">{{ $isAr?'اتصل بنا':'Contact Us' }}</span></small></div>
</div>
<section class="contact-hero">
    <div class="container">
        <h1>{{ $isAr ? ($contact?->hero_title_ar ?? 'اتصل بنا') : ($contact?->hero_title_en ?? 'Contact Us') }}</h1>
        <p>{{ $isAr ? ($contact?->hero_subtitle_ar ?? 'نحن هنا للإجابة على استفساراتك') : ($contact?->hero_subtitle_en ?? 'We are here to answer your inquiries') }}</p>
    </div>
</section>
<section class="contact-section">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
        @endif
        <div class="row g-4 mb-5">
            @if($contact?->email)
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="ic-icon">📧</div>
                    <h5>{{ $isAr?'البريد الإلكتروني':'Email' }}</h5>
                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                </div>
            </div>
            @endif
            @if($contact?->phone)
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="ic-icon">📞</div>
                    <h5>{{ $isAr?'الهاتف':'Phone' }}</h5>
                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                </div>
            </div>
            @endif
            @if($contact?->whatsapp)
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="ic-icon">💬</div>
                    <h5>{{ $isAr?'واتساب':'WhatsApp' }}</h5>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$contact->whatsapp) }}" target="_blank">{{ $contact->whatsapp }}</a>
                </div>
            </div>
            @endif
            @if($contact?->address_ar || $contact?->address_en)
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="ic-icon">📍</div>
                    <h5>{{ $isAr?'العنوان':'Address' }}</h5>
                    <p>{{ $isAr ? $contact->address_ar : $contact->address_en }}</p>
                </div>
            </div>
            @endif
        </div>
        <div class="row g-5 align-items-start">
            <div class="col-lg-7">
                <div class="form-card">
                    <h3 class="mb-4 fw-700" style="color:#1a7a4a">{{ $isAr?'أرسل رسالة':'Send a Message' }}</h3>
                    <form action="{{ url($locale.'/contact/send') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ $isAr?'الاسم الكامل':'Full Name' }} *</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ $isAr?'البريد الإلكتروني':'Email' }} *</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ $isAr?'الموضوع':'Subject' }}</label>
                                <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ $isAr?'الرسالة':'Message' }} *</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-send">{{ $isAr?'إرسال الرسالة':'Send Message' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                @if($contact && ($contact->facebook || $contact->twitter || $contact->instagram || $contact->youtube))
                <div class="info-card mb-4">
                    <h5 class="mb-3">{{ $isAr?'تابعنا على':'Follow Us' }}</h5>
                    <div class="social-links">
                        @if($contact->facebook)<a href="{{ $contact->facebook }}" target="_blank">f</a>@endif
                        @if($contact->twitter)<a href="{{ $contact->twitter }}" target="_blank">𝕏</a>@endif
                        @if($contact->instagram)<a href="{{ $contact->instagram }}" target="_blank">📷</a>@endif
                        @if($contact->youtube)<a href="{{ $contact->youtube }}" target="_blank">▶</a>@endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
