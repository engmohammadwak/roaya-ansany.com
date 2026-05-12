@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
    $c      = $contact; // ContactPage model
@endphp
@section('title', ($isAr ? 'تواصل معنا' : 'Contact Us') . ' | ' . config('app.name'))

@push('styles')
<style>
/* ── Contact Modal ── */
.contact-modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.55);z-index:9999;align-items:center;justify-content:center;}
.contact-modal-overlay.show{display:flex;}
.contact-modal{background:#fff;border-radius:20px;padding:2.5rem 2rem;max-width:420px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(15,23,42,.18);}
.contact-modal .modal-icon{font-size:3.5rem;margin-bottom:1rem;}
.contact-modal .modal-title{font-size:1.4rem;font-weight:700;margin-bottom:.5rem;}
.contact-modal .modal-body-text{color:#64748b;font-size:.95rem;margin-bottom:1.5rem;}
.contact-modal.fail .modal-title{color:#dc2626;}
.contact-modal .btn-modal-ok{border-radius:999px;padding:.55rem 2.5rem;font-weight:600;background:#0d6efd;color:#fff;border:none;cursor:pointer;}
.contact-modal.fail .btn-modal-ok{background:#dc2626;}
</style>
@endpush

@section('content')

{{-- ── Result Modal ── --}}
<div class="contact-modal-overlay" id="contactModalOverlay">
  <div class="contact-modal" id="contactModal">
    <div class="modal-icon" id="cModalIcon"></div>
    <div class="modal-title" id="cModalTitle"></div>
    <div class="modal-body-text" id="cModalBody"></div>
    <button class="btn-modal-ok" onclick="closeContactModal()">{{ $isAr ? 'حسناً' : 'OK' }}</button>
  </div>
</div>

{{-- ── Hero ── --}}
<section style="margin-top:8rem;">
  <div class="container">
    <div class="page-banner have-img main mt-3">
      <img class="the-img" src="{{ asset('website/images/line-8.svg') }}" alt="line">
      <div class="breadcrumbs mt-4 mb-4">
        <a href="{{ url($locale) }}">
          <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
          {{ $isAr ? 'الرئيسية' : 'Home' }}
        </a>
        <span>/</span>
        <a href="#" class="active">{{ $isAr ? 'تواصل معنا' : 'Contact Us' }}</a>
      </div>
      <div class="row mt-5">
        <div class="col-md-6">
          <h1 class="bg mt-4">
            {{ $isAr ? ($c->hero_title_ar ?? '') : ($c->hero_title_en ?? '') }}
          </h1>
          <form action="{{ url($locale.'/donate') }}" class="mt-5">
            <div class="row">
              <div class="col-8 col-lg-8">
                <input type="text" name="amount" class="form-input w-100" placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter amount' }}">
              </div>
              <div class="col-4 col-lg-4">
                <button type="submit" class="btn-donate w-100">{{ $isAr ? 'تبرع الآن' : 'Donate Now' }}</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-6">
          <p class="gray-color">{{ $isAr ? ($c->hero_subtitle_ar ?? '') : ($c->hero_subtitle_en ?? '') }}</p>
          <div class="social-black mt-4">
            @if($c && $c->facebook)
            <a href="{{ $c->facebook }}" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 50 50"><path d="M41,4H9C6.24,4,4,6.24,4,9v32c0,2.76,2.24,5,5,5h32c2.76,0,5-2.24,5-5V9C46,6.24,43.76,4,41,4z M37,19h-2c-2.14,0-3,0.5-3,2 v3h5l-1,5h-4v15h-5V29h-4v-5h4v-3c0-4,2-7,6-7c2.9,0,4,1,4,1V19z"></path></svg>
            </a>
            @endif
            @if($c && $c->instagram)
            <a href="{{ $c->instagram }}" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 50 50"><path d="M 16 3 C 8.83 3 3 8.83 3 16 L 3 34 C 3 41.17 8.83 47 16 47 L 34 47 C 41.17 47 47 41.17 47 34 L 47 16 C 47 8.83 41.17 3 34 3 L 16 3 z M 37 11 C 38.1 11 39 11.9 39 13 C 39 14.1 38.1 15 37 15 C 35.9 15 35 14.1 35 13 C 35 11.9 35.9 11 37 11 z M 25 14 C 31.07 14 36 18.93 36 25 C 36 31.07 31.07 36 25 36 C 18.93 36 14 31.07 14 25 C 14 18.93 18.93 14 25 14 z M 25 16 C 20.04 16 16 20.04 16 25 C 16 29.96 20.04 34 25 34 C 29.96 34 34 29.96 34 25 C 34 20.04 29.96 16 25 16 z"></path></svg>
            </a>
            @endif
            @if($c && $c->twitter)
            <a href="{{ $c->twitter }}" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 50 50"><path d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z"></path></svg>
            </a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ── Info Cards ── --}}
<section class="main-section">
  <div class="container">
    <div class="info-section">
      <div class="row">
        @if($c && $c->email)
        <div class="col-md-3 mb-3">
          <div class="info-card">
            <div class="info">
              <p class="mb-2">{{ $isAr ? 'الايميل' : 'Email' }}</p>
              <p><a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="mailto:{{ $c->email }}">{{ $c->email }}</a></p>
            </div>
            <div class="icon"><a href="mailto:{{ $c->email }}"><img src="{{ asset('website/images/info-arrow.svg') }}" alt="info"></a></div>
          </div>
        </div>
        @endif
        @if($c && $c->phone)
        <div class="col-md-3 mb-3">
          <div class="info-card">
            <div class="info">
              <p class="mb-2">{{ $isAr ? 'رقم الموبايل' : 'Phone' }}</p>
              <p dir="ltr"><a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="tel:{{ $c->phone }}">{{ $c->phone }}</a></p>
            </div>
            <div class="icon"><a href="tel:{{ $c->phone }}"><img src="{{ asset('website/images/info-arrow.svg') }}" alt="info"></a></div>
          </div>
        </div>
        @endif
        @if($c && $c->fax)
        <div class="col-md-3 mb-3">
          <div class="info-card">
            <div class="info">
              <p class="mb-2">{{ $isAr ? 'فاكس' : 'Fax' }}</p>
              <p dir="ltr"><a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="tel:{{ $c->fax }}">{{ $c->fax }}</a></p>
            </div>
            <div class="icon"><a href="tel:{{ $c->fax }}"><img src="{{ asset('website/images/info-arrow.svg') }}" alt="info"></a></div>
          </div>
        </div>
        @endif
        @if($c && ($c->work_hours_ar || $c->work_hours_en))
        <div class="col-md-3 mb-3">
          <div class="info-card">
            <div class="info">
              <p class="mb-2">{{ $isAr ? 'ساعات العمل' : 'Working Hours' }}</p>
              <p>{{ $isAr ? $c->work_hours_ar : $c->work_hours_en }}</p>
            </div>
            <div class="icon"><a href="#"><img src="{{ asset('website/images/info-arrow.svg') }}" alt="info"></a></div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

{{-- ── Contact Form ── --}}
<section class="main-section">
  <div class="contact-form">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <form id="contactForm" class="bg-white p-4" novalidate>
            @csrf
            <div class="row mb-4">
              <div class="col-md-6 mb-3 mb-md-0">
                <label for="firstName" class="form-label">{{ $isAr ? 'الاسم الأول' : 'First Name' }}</label>
                <input type="text" class="form-control" id="firstName" name="first_name" placeholder="{{ $isAr ? 'ادخل اسمك الأول' : 'First name' }}" required>
                <div class="invalid-feedback">{{ $isAr ? 'الاسم مطلوب' : 'Name is required' }}</div>
              </div>
              <div class="col-md-6">
                <label for="lastName" class="form-label">{{ $isAr ? 'اسم العائلة' : 'Last Name' }}</label>
                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="{{ $isAr ? 'ادخل العائلة' : 'Last name' }}">
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6 mb-3 mb-md-0">
                <label for="email" class="form-label">{{ $isAr ? 'الايميل' : 'Email' }}</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="mail@example.com" required>
                <div class="invalid-feedback">{{ $isAr ? 'بريد إلكتروني غير صالح' : 'Invalid email' }}</div>
              </div>
              <div class="col-md-6">
                <label for="phone" class="form-label">{{ $isAr ? 'رقم الموبايل' : 'Phone' }}</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="{{ $isAr ? 'ادخل رقمك' : 'Your number' }}">
              </div>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">{{ $isAr ? 'رسالتك لنا' : 'Your Message' }}</label>
              <textarea class="form-control" id="message" name="message" rows="4" placeholder="{{ $isAr ? 'اكتب رسالتك...' : 'Write your message...' }}" required></textarea>
              <div class="invalid-feedback">{{ $isAr ? 'الرسالة مطلوبة (5 أحرف على الأقل)' : 'Message required (min 5 chars)' }}</div>
            </div>
            <div class="footer mt-4 mb-4 d-flex justify-content-between align-items-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmData" required>
                <label class="form-check-label" for="confirmData">{{ $isAr ? 'أؤكد أن كل بياناتي صحيحة' : 'I confirm my data is correct' }}</label>
              </div>
              <button type="submit" class="btn-send" id="contactSubmitBtn">
                <span id="contactBtnText">{{ $isAr ? 'ارسال' : 'Send' }}</span>
                <span id="contactBtnLoader" style="display:none">
                  <span class="spinner-border spinner-border-sm me-1"></span>
                  {{ $isAr ? 'جارٍ الإرسال...' : 'Sending...' }}
                </span>
              </button>
            </div>
          </form>
        </div>

        <div class="col-md-4">
          <div class="row">
            <div class="col-md-12 text-end">
              <img class="img-fluid w-100 h-100" src="{{ asset('website/images/contact.svg') }}" alt="contact">
            </div>
            @if($c && ($c->card_text_ar || $c->card_text_en))
            <div class="col-md-12 mt-3">
              <div class="info-card">
                <div class="info">
                  <p class="mb-2">{{ $isAr ? ($c->card_text_ar ?? '') : ($c->card_text_en ?? '') }}</p>
                  @if($c->email)
                  <p><a class="link-offset-2 link-underline link-underline-opacity-0 link-secondary" href="mailto:{{ $c->email }}">{{ $c->email }}</a></p>
                  @endif
                </div>
                <div class="icon">
                  @if($c->email)
                  <a href="mailto:{{ $c->email }}"><img src="{{ asset('website/images/info-arrow.svg') }}" alt="info"></a>
                  @endif
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
const IS_AR       = {{ $isAr ? 'true' : 'false' }};
const CONTACT_URL = "{{ url($locale.'/contact') }}";
const SUCCESS_MSG = @json($isAr ? ($contact->success_msg_ar ?? 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.') : ($contact->success_msg_en ?? 'Your message was sent successfully!'));
const FAIL_MSG    = @json($isAr ? ($contact->fail_msg_ar ?? 'حدث خطأ، يرجى المحاولة مرة أخرى.') : ($contact->fail_msg_en ?? 'Something went wrong, please try again.'));

function showContactModal(success, msg) {
  const modal = document.getElementById('contactModal');
  const overlay = document.getElementById('contactModalOverlay');
  document.getElementById('cModalIcon').textContent  = success ? '✅' : '❌';
  document.getElementById('cModalTitle').textContent = success
    ? (IS_AR ? 'تم الإرسال بنجاح!' : 'Sent Successfully!')
    : (IS_AR ? 'حدث خطأ' : 'Error');
  document.getElementById('cModalBody').textContent  = msg;
  modal.classList.toggle('fail', !success);
  overlay.classList.add('show');
}
function closeContactModal() {
  document.getElementById('contactModalOverlay').classList.remove('show');
}
document.getElementById('contactModalOverlay').addEventListener('click', function(e) {
  if (e.target === this) closeContactModal();
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeContactModal();
});

// ── Validation ──
function validateContact() {
  let ok = true;
  const fn = document.getElementById('firstName');
  const em = document.getElementById('email');
  const ms = document.getElementById('message');
  if (!fn.value.trim() || fn.value.trim().length < 2) { fn.classList.add('is-invalid'); ok = false; } else fn.classList.remove('is-invalid');
  if (!em.value.trim() || !/^[^@]+@[^@]+\.[^@]+$/.test(em.value.trim())) { em.classList.add('is-invalid'); ok = false; } else em.classList.remove('is-invalid');
  if (!ms.value.trim() || ms.value.trim().length < 5) { ms.classList.add('is-invalid'); ok = false; } else ms.classList.remove('is-invalid');
  return ok;
}
document.querySelectorAll('#contactForm input, #contactForm textarea').forEach(el => {
  el.addEventListener('input', () => el.classList.remove('is-invalid'));
});

// ── AJAX Submit ──
document.getElementById('contactForm').addEventListener('submit', function(e) {
  e.preventDefault();
  if (!document.getElementById('confirmData').checked) {
    alert(IS_AR ? 'يجب الموافقة قبل إرسال النموذج.' : 'Please confirm your data first.');
    return;
  }
  if (!validateContact()) return;

  const btn    = document.getElementById('contactSubmitBtn');
  const txt    = document.getElementById('contactBtnText');
  const loader = document.getElementById('contactBtnLoader');
  btn.disabled = true; txt.style.display = 'none'; loader.style.display = 'inline-flex';

  const formData = new FormData(this);

  fetch(CONTACT_URL, {
    method: 'POST',
    body: formData,
    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
  })
  .then(r => r.json())
  .then(res => {
    btn.disabled = false; txt.style.display = ''; loader.style.display = 'none';
    if (res.success) {
      document.getElementById('contactForm').reset();
      showContactModal(true, res.message || SUCCESS_MSG);
    } else {
      showContactModal(false, res.message || FAIL_MSG);
    }
  })
  .catch(() => {
    btn.disabled = false; txt.style.display = ''; loader.style.display = 'none';
    showContactModal(false, FAIL_MSG);
  });
});
</script>
@endpush
