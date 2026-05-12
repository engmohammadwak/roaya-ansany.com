@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'اتصل بنا':'Contact Us') . ' | مؤسسة رؤيا الإنسانية')
@section('description', $locale==='ar'?'تواصل مع مؤسسة رؤيا الإنسانية عبر الهاتف أو البريد الإلكتروني.':'Contact Roaya Insanya Foundation via phone or email.')

@section('content')

<section class="page-hero-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url($locale) }}">{{ $locale==='ar'?'الرئيسية':'Home' }}</a></li>
                <li class="breadcrumb-item active">{{ $locale==='ar'?'اتصل بنا':'Contact Us' }}</li>
            </ol>
        </nav>
        <h1 class="section-title">{{ $locale==='ar'?'اتصل بنا':'Contact Us' }}</h1>
        <p class="muted-color mt-2">{{ $locale==='ar'?'نحن هنا لمساعدتك، لا تتردد في التواصل معنا.':'We are here to help you, feel free to reach out.' }}</p>
    </div>
</section>

<section class="main-section">
    <div class="container">
        <div class="row g-5">

            {{-- Contact Info --}}
            <div class="col-lg-4">
                <h4 class="mb-4">{{ $locale==='ar'?'معلومات التواصل':'Contact Information' }}</h4>
                <div class="contact-info-list">
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fa-solid fa-phone"></i></div>
                        <div>
                            <div class="contact-info-label">{{ $locale==='ar'?'الهاتف':'Phone' }}</div>
                            <a href="tel:+905398863777" class="contact-info-value">+90 539 886 3777</a>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div>
                            <div class="contact-info-label">{{ $locale==='ar'?'البريد الإلكتروني':'Email' }}</div>
                            <a href="mailto:info@roaya-ansany.com" class="contact-info-value">info@roaya-ansany.com</a>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <div class="contact-info-label">{{ $locale==='ar'?'العنوان':'Address' }}</div>
                            <div class="contact-info-value">{{ $locale==='ar'?'تركيا':'Turkey' }}</div>
                        </div>
                    </div>
                    <div class="contact-info-item">
                        <div class="contact-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div>
                            <div class="contact-info-label">WhatsApp</div>
                            <a href="https://api.whatsapp.com/send/?phone=905398863777" target="_blank" class="contact-info-value">+90 539 886 3777</a>
                        </div>
                    </div>
                </div>

                {{-- Social --}}
                <div class="mt-5">
                    <h6 class="mb-3">{{ $locale==='ar'?'تابعنا على:':'Follow Us:' }}</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon-btn"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="social-icon-btn"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="social-icon-btn"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="#" class="social-icon-btn"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="col-lg-8">
                <div class="contact-form-box">
                    <h4 class="mb-4">{{ $locale==='ar'?'أرسل لنا رسالة':'Send Us a Message' }}</h4>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ url($locale.'/contact') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">{{ $locale==='ar'?'الاسم الكامل':'Full Name' }} *</label>
                                <input type="text" name="name" class="form-input w-100 @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="{{ $locale==='ar'?'أدخل اسمك الكامل':'Enter your full name' }}" required>
                                @error('name')<div class="text-danger mt-1" style="font-size:13px">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">{{ $locale==='ar'?'البريد الإلكتروني':'Email' }} *</label>
                                <input type="email" name="email" class="form-input w-100 @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="example@email.com" required>
                                @error('email')<div class="text-danger mt-1" style="font-size:13px">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ $locale==='ar'?'رقم الهاتف':'Phone Number' }}</label>
                                <input type="tel" name="phone" class="form-input w-100"
                                    value="{{ old('phone') }}" placeholder="+970 ..........">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ $locale==='ar'?'الموضوع':'Subject' }} *</label>
                                <input type="text" name="subject" class="form-input w-100 @error('subject') is-invalid @enderror"
                                    value="{{ old('subject') }}" placeholder="{{ $locale==='ar'?'موضوع الرسالة':'Message subject' }}" required>
                                @error('subject')<div class="text-danger mt-1" style="font-size:13px">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ $locale==='ar'?'الرسالة':'Message' }} *</label>
                                <textarea name="message" rows="6" class="form-input w-100 @error('message') is-invalid @enderror"
                                    placeholder="{{ $locale==='ar'?'اكتب رسالتك هنا...':'Write your message here...' }}" required>{{ old('message') }}</textarea>
                                @error('message')<div class="text-danger mt-1" style="font-size:13px">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-donate px-5">
                                    <i class="fa-solid fa-paper-plane me-2"></i>
                                    {{ $locale==='ar'?'إرسال الرسالة':'Send Message' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
.page-hero-section { background:linear-gradient(135deg,#f8fdf4,#eef7e6); padding:60px 0 40px; }
.page-hero-section .breadcrumb-item a { color:#5a9e2f; text-decoration:none; }
.contact-info-list { display:flex; flex-direction:column; gap:20px; }
.contact-info-item { display:flex; align-items:flex-start; gap:16px; padding:16px; background:#f8fdf4; border-radius:12px; border:1px solid rgba(90,158,47,0.1); }
.contact-icon { width:42px; height:42px; background:linear-gradient(135deg,#5a9e2f,#7bc244); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.contact-icon i { color:white; font-size:16px; }
.contact-info-label { font-size:12px; color:#999; margin-bottom:3px; }
.contact-info-value { font-weight:600; color:#333; text-decoration:none; font-size:14px; }
.contact-info-value:hover { color:#5a9e2f; }
.contact-form-box { background:white; border-radius:20px; padding:40px; box-shadow:0 4px 24px rgba(0,0,0,0.07); border:1px solid #e8f4d9; }
.social-icon-btn { width:40px; height:40px; background:#f8fdf4; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#5a9e2f; border:1px solid rgba(90,158,47,0.2); transition:all 0.3s; }
.social-icon-btn:hover { background:#5a9e2f; color:white; }
.form-label { font-size:14px; font-weight:600; color:#444; margin-bottom:6px; display:block; }
textarea.form-input { resize:none; padding-top:12px; }
</style>
@endpush
@endsection
