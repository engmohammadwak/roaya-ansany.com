@extends('layouts.app')
@section('title', ($success ? ($isAr ? 'تم الدفع' : 'Payment Successful') : ($isAr ? 'فشل الدفع' : 'Payment Failed')) . ' | ' . config('app.name'))

@push('styles')
<style>
.result-wrap{min-height:60vh;display:flex;align-items:center;justify-content:center;}
.result-card{background:#fff;border-radius:20px;padding:3rem 2.5rem;max-width:480px;width:100%;text-align:center;box-shadow:0 20px 60px rgba(15,23,42,.12);}
.result-icon{font-size:4rem;margin-bottom:1rem;}
.result-amount{font-size:2rem;font-weight:800;margin-bottom:.25rem;}
.result-campaign{background:#f0fdf4;border-radius:10px;padding:.75rem 1rem;color:#166534;font-weight:600;font-size:.9rem;margin:1rem 0;display:inline-block;width:100%;}
.result-card.fail .result-campaign{background:#fef2f2;color:#991b1b;}
.result-card.fail .result-amount{color:#dc2626;}
.result-card.success .result-amount{color:#0d6efd;}
</style>
@endpush

@section('content')
<div class="result-wrap first-container">
  <div class="result-card {{ $success ? 'success' : 'fail' }}">
    <div class="result-icon">{{ $success ? '✅' : '❌' }}</div>
    @if($donation)
      <div class="result-amount">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</div>
    @endif
    <h2 class="mt-2 mb-1" style="font-size:1.5rem;font-weight:700">
      {{ $success ? ($isAr ? 'تم التبرع بنجاح!' : 'Donation Successful!') : ($isAr ? 'لم يتم الدفع' : 'Payment Failed') }}
    </h2>
    <p class="text-muted mb-2" style="font-size:.95rem">
      {{ $success
        ? ($isAr ? 'شكراً لك، سيُوظَّف تبرعك في أفضل المشاريع.' : 'Thank you! Your donation will be directed to the best projects.')
        : ($isAr ? 'حدث خطأ أثناء الدفع. يرجى المحاولة مرة أخرى.' : 'Something went wrong. Please try again.')
      }}
    </p>
    @if($campaignName)
      <div class="result-campaign">
        {{ $isAr ? 'لحملة: ' : 'Campaign: ' }}{{ $campaignName }}
      </div>
    @endif
    <div class="d-flex gap-2 mt-3 justify-content-center">
      <a href="{{ url($locale) }}" class="btn btn-outline-secondary" style="border-radius:999px;padding:.5rem 1.5rem">
        {{ $isAr ? 'الرئيسية' : 'Home' }}
      </a>
      @if(!$success)
      <a href="{{ url($locale.'/donate') }}" class="btn btn-donate-now" style="border-radius:999px;padding:.5rem 1.5rem">
        {{ $isAr ? 'حاول مرة أخرى' : 'Try Again' }}
      </a>
      @endif
    </div>
  </div>
</div>
@endsection
