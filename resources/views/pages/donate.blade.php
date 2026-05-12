@extends('layouts.app')
@php
    $locale = app()->getLocale();
    $isAr   = $locale === 'ar';
    $currency = session('currency', 'USD');
    $amounts  = [50, 100, 200, 500, 1000];
    $currencies = ['TRY','USD','EUR','GBP','CAD','OMR','AUD'];
    $fxRates = \App\Models\Setting::getFxRates() ?? [];
@endphp
@section('title', ($isAr ? 'تبرع الآن' : 'Donate Now') . ' | ' . config('app.name'))

@push('styles')
<style>
.preview-number{letter-spacing:2px;font-weight:700;font-size:1.35rem}
.form-label{font-weight:600}
.donation-card{background:#fff;border:1px solid #eee;border-radius:16px;padding:1.25rem;box-shadow:0 10px 30px rgba(15,23,42,.05);}
.progress-bar{background:#e2e8f0;border-radius:9999px;height:7px;overflow:hidden}
.progress-fill{background:#0d6efd;height:100%}
.btn-details{background:#0f172a;color:#fff;border-radius:999px;text-align:center;padding:.4rem .75rem;display:inline-block;text-decoration:none}
.muted{opacity:.85;font-size:.65rem}
html[dir="rtl"] .num-ltr{direction:ltr;text-align:left;}
</style>
@endpush

@section('content')
<section class="donate-section first-container">
  <div class="container">
    <div class="breadcrumbs mt-4 mb-4">
      <a href="{{ url($locale) }}">
        <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
        {{ $isAr ? 'الرئيسية' : 'Home' }}
      </a>
      <span>/</span>
      <a href="#" class="active">{{ $isAr ? 'دفع التبرع' : 'Donate' }}</a>
    </div>

    <div class="row mt-4 g-4">

      {{-- ===== LEFT: FORM ===== --}}
      <div class="col-md-7 order-2 order-lg-1">
        <div class="donate-form">
          <div class="head d-flex justify-content-between align-items-center">
            <h1>{{ $isAr ? 'دفع آمن ثلاثي الأبعاد' : 'Secure 3D Payment' }}</h1>
            <span class="btn-currency text-uppercase" id="pv-currency-top">{{ $currency }}</span>
          </div>
          <p class="dark-text-color mt-3">{{ $isAr ? 'اختر مبلغ التبرع الخاص بك' : 'Choose your donation amount' }}</p>

          <form method="POST" action="{{ url($locale.'/donate/payment/3d/form') }}" id="payForm" novalidate>
            @csrf

            {{-- Quick amounts --}}
            <div class="amounts gap-2 d-flex flex-wrap mt-3">
              @foreach($amounts as $a)
              <div>
                <input type="radio" name="select-amount" id="amt-{{ $a }}" class="filter-check d-none">
                <label for="amt-{{ $a }}" class="filter-btn donate-now-btn num-ltr" data-amount="{{ $a }}">
                  <p class="m-0">{{ $a }}</p>
                </label>
              </div>
              @endforeach
            </div>

            <div class="row mt-4">
              <div class="col-md-6 mb-3">
                <label for="amount-input" class="form-label">{{ $isAr ? 'المبلغ' : 'Amount' }}</label>
                <div class="input-group">
                  <span class="input-group-text num-ltr" id="currencyPrefix">{{ $currency === 'TRY' ? 'TL' : $currency }}</span>
                  <input type="number" step="0.01" min="0.10"
                    class="form-control form-input num-ltr"
                    name="amount" id="amount-input"
                    value="{{ request('amount', '50.00') }}" required>
                </div>
                <div class="small text-muted mt-1" id="fx-hint" style="min-height:1.2em">
                  ≈ <span class="num-ltr" id="fx-eq-val">TL —</span>
                </div>
                <div class="invalid-feedback">{{ $isAr ? 'أدخل مبلغًا صحيحًا (≥ 0.10)' : 'Enter a valid amount (≥ 0.10)' }}</div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="currency" class="form-label">{{ $isAr ? 'العملة' : 'Currency' }}</label>
                <select class="form-control form-select" name="currency" id="currency">
                  @foreach($currencies as $c)
                  <option value="{{ $c }}" @selected($c === $currency)>{{ $c }}</option>
                  @endforeach
                </select>
                <div class="small text-muted mt-2">{{ $isAr ? 'اختر مبلغًا سريعًا أو عدّل الحقل يدويًا.' : 'Pick a quick amount or edit manually.' }}</div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-12 mb-3">
                <label class="form-label">{{ $isAr ? 'رقم البطاقة' : 'Card Number' }}</label>
                <input type="text" class="form-control form-input num-ltr"
                  name="number" id="cc-number"
                  placeholder="4111 1111 1111 1111"
                  inputmode="numeric" maxlength="19" required>
                <div class="small text-muted mt-1">{{ $isAr ? 'سنتحقق من صحة البطاقة تلقائيًا.' : 'We validate your card automatically.' }}</div>
                <div class="invalid-feedback">{{ $isAr ? 'رقم البطاقة غير صالح' : 'Invalid card number' }}</div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">{{ $isAr ? 'اسم حامل البطاقة' : 'Cardholder Name' }}</label>
                <input type="text" class="form-control form-input"
                  name="name" id="cc-name"
                  placeholder="{{ $isAr ? 'الاسم الكامل' : 'Full Name' }}" required>
                <div class="invalid-feedback">{{ $isAr ? 'يرجى إدخال الاسم' : 'Please enter your name' }}</div>
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">{{ $isAr ? 'شهر (MM)' : 'Month (MM)' }}</label>
                <input type="text" class="form-control form-input num-ltr"
                  name="month" id="cc-month"
                  placeholder="12" inputmode="numeric" maxlength="2" required>
                <div class="invalid-feedback">{{ $isAr ? 'شهر غير صالح' : 'Invalid month' }}</div>
              </div>
              <div class="col-md-3 mb-3">
                <label class="form-label">{{ $isAr ? 'سنة (YYYY)' : 'Year (YYYY)' }}</label>
                <input type="text" class="form-control form-input num-ltr"
                  name="year" id="cc-year"
                  placeholder="2027" inputmode="numeric" maxlength="4" required>
                <div class="invalid-feedback">{{ $isAr ? 'سنة غير صالحة' : 'Invalid year' }}</div>
              </div>

              <div class="col-md-3 mb-3">
                <label class="form-label">CVV</label>
                <input type="password" class="form-control form-input num-ltr"
                  name="cvv" id="cc-cvv"
                  placeholder="000" inputmode="numeric" maxlength="4" required>
                <div class="invalid-feedback">{{ $isAr ? 'CVV غير صالح' : 'Invalid CVV' }}</div>
              </div>
              <div class="col-md-9 mb-3">
                <label class="form-label">{{ $isAr ? 'البريد الإلكتروني (اختياري)' : 'Email (optional)' }}</label>
                <input type="email" class="form-control form-input"
                  name="email" placeholder="mail@example.com">
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">{{ $isAr ? 'الوصف' : 'Description' }}</label>
                <input type="text" class="form-control form-input"
                  name="description" id="cc-desc" value="">
              </div>
            </div>

            <div class="footer d-flex flex-wrap align-items-center gap-3 mt-2">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="confirmData" checked>
                <label class="form-check-label dark-text-color" for="confirmData">
                  {{ $isAr ? 'بإتمام التبرع أنت توافق على' : 'By donating you agree to our' }}
                  <a href="{{ url($locale.'/terms-and-conditions') }}" class="main-color">{{ $isAr ? 'سياسات التبرع' : 'donation policies' }}</a>
                  {{ $isAr ? 'كاملة' : '' }}
                </label>
              </div>
              <input type="hidden" name="recaptcha_token" id="recaptcha_token">
              <button class="btn btn-donate-now px-4 ms-auto" type="submit" id="submitBtn">
                {{ $isAr ? 'ادفع الآن' : 'Pay Now' }}
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- ===== RIGHT: CARD PREVIEW ===== --}}
      <div class="col-md-5 order-1 order-lg-2">
        <div class="row g-3">
          <div class="col-12 campaign-section">
            <div class="donation-card d-flex justify-content-between flex-column card p-4 h-100 card-hero" id="cardPreview">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <div class="fw-semibold" style="opacity:.9">{{ $isAr ? 'بطاقة دفع آمنة' : 'Secure Payment Card' }}</div>
                  <div class="small muted">{{ $isAr ? 'رؤيا الإنسانية' : 'Roaya Ansany' }}</div>
                </div>
                <img id="brandLogo" style="width:15% !important" alt="brand"
                  src="{{ asset('website/images/logo.svg') }}">
              </div>

              <div class="mt-5">
                <div class="preview-number num-ltr" id="pv-number">•••• •••• •••• ••••</div>
                <div class="d-flex gap-4 mt-3 small">
                  <div>
                    <div class="muted">{{ $isAr ? 'اسم حامل البطاقة' : 'Cardholder' }}</div>
                    <div id="pv-name" class="text-truncate">{{ $isAr ? 'اسم حامل البطاقة' : 'Cardholder Name' }}</div>
                  </div>
                  <div>
                    <div class="muted">{{ $isAr ? 'انتهاء' : 'Expires' }}</div>
                    <div id="pv-exp" class="num-ltr">MM/YY</div>
                  </div>
                </div>
              </div>

              <div class="mt-auto d-flex justify-content-between align-items-end" style="min-height:40px">
                <div class="small num-ltr" id="pv-amount">{{ $currency }} {{ number_format(request('amount', 50), 2) }}</div>
                <div class="badge bg-light text-dark" id="pv-currency">{{ $currency }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>{{-- row --}}
  </div>
</section>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.FX_TO_TRY = @json($fxRates);
window.DEFAULT_CURRENCY = "{{ $currency }}";

function onlyDigits(s){return(s||'').replace(/\D+/g,'');}
function formatCard(num){num=onlyDigits(num).slice(0,19);return num.replace(/(.{4})/g,'$1 ').trim();}
function luhnCheck(num){
  num=onlyDigits(num);
  if(num.length<12)return false;
  let sum=0,dbl=false;
  for(let i=num.length-1;i>=0;i--){
    let d=parseInt(num[i],10);
    if(dbl){d*=2;if(d>9)d-=9;}
    sum+=d;dbl=!dbl;
  }
  return sum%10===0;
}
function detectBrand(num){
  num=onlyDigits(num);
  if(/^4/.test(num))return 'visa';
  if(/^(5[1-5]|2(2[2-9]|[3-6]\d|7[01]|720))/.test(num))return 'mc';
  if(/^3[47]/.test(num))return 'amex';
  return 'unknown';
}
const brandLogos={
  visa:'https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg',
  mc:'https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg',
  amex:'https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg',
  unknown:'{{ asset('website/images/logo.svg') }}'
};

function updateFxHint(){
  const cur=($('#currency').val()||'TRY').toUpperCase();
  const amt=parseFloat($('#amount-input').val()||'0')||0;
  let txt='TL —';
  if(cur==='TRY'){txt='TL '+amt.toFixed(2);}
  else{
    const rate=(window.FX_TO_TRY&&window.FX_TO_TRY[cur])?parseFloat(window.FX_TO_TRY[cur]):null;
    if(rate&&rate>0)txt='TL '+(amt*rate).toFixed(2);
  }
  $('#fx-eq-val').text(txt);
}

$('#cc-number').on('input',function(){
  const f=formatCard(this.value);
  this.value=f;
  $('#pv-number').text(f||'•••• •••• •••• ••••');
  const brand=detectBrand(f);
  $('#brandLogo').attr('src',brandLogos[brand]||brandLogos.unknown);
});
$('#cc-name').on('input',function(){
  $('#pv-name').text(this.value||'{{ $isAr ? 'اسم حامل البطاقة' : 'Cardholder Name' }}');
});
$('#cc-month,#cc-year').on('input',function(){
  const mm=onlyDigits($('#cc-month').val()).slice(0,2);
  const yy=onlyDigits($('#cc-year').val()).slice(-2);
  $('#cc-month').val(mm);
  $('#cc-year').val(onlyDigits($('#cc-year').val()).slice(0,4));
  $('#pv-exp').text((mm?mm:'MM')+'/'+(yy?yy:'YY'));
});
$('input[name="amount"]').on('input',function(){
  const cur=$('#currency').val();
  const val=(parseFloat(this.value||'0')||0).toFixed(2);
  $('#pv-amount').text((cur==='TRY'?'TL':cur)+' '+val);
  $('#pv-currency-top').text(cur);
  updateFxHint();
});
$('#currency').on('change',function(){
  const c=this.value;
  $('#pv-currency').text(c);
  $('#pv-currency-top').text(c);
  $('#currencyPrefix').text(c==='TRY'?'TL':c);
  $('input[name="amount"]').trigger('input');
  updateFxHint();
});
$(document).on('click','.donate-now-btn',function(){
  $('.donate-now-btn').removeClass('active');
  $(this).addClass('active');
  const amt=parseFloat($(this).data('amount'))||0;
  $('#amount-input').val(amt.toFixed(2)).trigger('input').trigger('change');
});

function validateForm(){
  let ok=true;
  const amt=parseFloat($('input[name="amount"]').val()||'0');
  if(!(amt>=0.10)){ok=false;$('input[name="amount"]')[0].classList.add('is-invalid');}else $('input[name="amount"]')[0].classList.remove('is-invalid');
  const name=$('#cc-name').val().trim();
  if(name.length<2){ok=false;$('#cc-name')[0].classList.add('is-invalid');}else $('#cc-name')[0].classList.remove('is-invalid');
  const raw=onlyDigits($('#cc-number').val());
  if(!luhnCheck(raw)){ok=false;$('#cc-number')[0].classList.add('is-invalid');}else $('#cc-number')[0].classList.remove('is-invalid');
  const mm=parseInt(onlyDigits($('#cc-month').val()),10);
  const yyyy=parseInt(onlyDigits($('#cc-year').val()),10);
  const now=new Date();
  const validMonth=mm>=1&&mm<=12;
  const validYear=yyyy>=now.getFullYear()&&yyyy<=now.getFullYear()+15;
  let notExpired=true;
  if(validMonth&&validYear){const exp=new Date(yyyy,mm-1,1);notExpired=exp>=new Date(now.getFullYear(),now.getMonth(),1);}
  if(!(validMonth&&validYear&&notExpired)){ok=false;$('#cc-month')[0].classList.add('is-invalid');$('#cc-year')[0].classList.add('is-invalid');}else{$('#cc-month')[0].classList.remove('is-invalid');$('#cc-year')[0].classList.remove('is-invalid');}
  const brand=detectBrand(raw);
  const cvv=onlyDigits($('#cc-cvv').val());
  const need=(brand==='amex')?4:3;
  if(!(cvv.length===need)){ok=false;$('#cc-cvv')[0].classList.add('is-invalid');}else $('#cc-cvv')[0].classList.remove('is-invalid');
  return ok;
}
$('#payForm input,#payForm select').on('change keyup blur',validateForm);

const RECAPTCHA_SITE_KEY='{{ config('services.recaptcha.site_key','6LeoNGcsAAAAAIqn8NMLUB0l3vyX_-SAu1w1Ki-s') }}';
$('#payForm').on('submit',function(e){
  e.preventDefault();
  if(!$('#confirmData').is(':checked')){alert('{{ $isAr ? 'يرجى الموافقة على سياسات التبرع أولاً' : 'Please accept donation policies first' }}');return;}
  if(!validateForm())return;
  $('#submitBtn').prop('disabled',true).addClass('disabled');
  if(typeof grecaptcha==='undefined'){alert('reCAPTCHA not loaded');$('#submitBtn').prop('disabled',false).removeClass('disabled');return;}
  grecaptcha.ready(function(){
    grecaptcha.execute(RECAPTCHA_SITE_KEY,{action:'donate'})
      .then(function(token){
        document.getElementById('recaptcha_token').value=token;
        document.getElementById('payForm').submit();
      })
      .catch(function(){
        $('#submitBtn').prop('disabled',false).removeClass('disabled');
        alert('reCAPTCHA failed');
      });
  });
});

(function boot(){
  const c=$('#currency').val()||'{{ $currency }}';
  $('#pv-currency').text(c);
  $('#pv-currency-top').text(c);
  $('#currencyPrefix').text(c==='TRY'?'TL':c);
  $('input[name="amount"],#cc-number,#cc-name,#cc-month,#cc-year').trigger('input');
  updateFxHint();
})();
</script>
@endpush
