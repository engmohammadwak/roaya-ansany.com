@extends('layouts.app')
@php
    $locale   = app()->getLocale();
    $project  = $campaign['data'] ?? $campaign ?? [];
    $title    = $project['title'] ?? ($locale==='ar'?'تفاصيل الحملة':'Campaign Details');
    $desc     = $project['description'] ?? $project['content'] ?? '';
    $img      = $project['image'] ?? $project['thumbnail'] ?? '';
    $goal     = $project['goal_amount'] ?? 0;
    $raised   = $project['raised_amount'] ?? 0;
    $percent  = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
    $related  = $related['data'] ?? [];
@endphp
@section('title', $title . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <div class="row">

            {{-- Main Content --}}
            <div class="col-lg-8 mb-5">
                @if($img)
                <img src="{{ $img }}" class="img-fluid rounded mb-4 w-100" alt="{{ $title }}" style="max-height:420px; object-fit:cover;">
                @endif

                <h1 class="section-title mb-4">{{ $title }}</h1>
                <div class="muted-color" style="line-height:1.9;">{!! $desc !!}</div>
            </div>

            {{-- Sidebar Donate Box --}}
            <div class="col-lg-4">
                <div class="why-donate-card" style="position:sticky; top:90px;">
                    <h5 class="mb-4">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</h5>

                    {{-- Stats --}}
                    <div class="d-flex justify-content-between small text-muted mb-2">
                        <div>
                            <div>{{ $locale==='ar'?'الهدف':'Goal' }}</div>
                            <strong>${{ number_format($goal) }}</strong>
                        </div>
                        <div>
                            <div>{{ $locale==='ar'?'المُجمَّع':'Raised' }}</div>
                            <strong>${{ number_format($raised) }}</strong>
                        </div>
                        <div>
                            <div>{{ $locale==='ar'?'المتبقي':'Left' }}</div>
                            <strong>${{ number_format(max(0,$goal-$raised)) }}</strong>
                        </div>
                    </div>

                    {{-- Progress --}}
                    <div class="progress-container mb-4">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width:{{ $percent }}%"></div>
                        </div>
                    </div>
                    <p class="small muted-color mb-4">{{ $percent }}% {{ $locale==='ar'?'من الهدف':'of goal' }}</p>

                    {{-- Quick amounts --}}
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        @foreach([10,25,50,100,250,500] as $amt)
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="document.getElementById('donate-amount').value={{ $amt }}">{{ $amt }}</button>
                        @endforeach
                    </div>

                    <input type="text" name="amount" id="donate-amount" class="form-input w-100 mb-3"
                        placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}" value="25">

                    <button type="button" class="btn-donate w-100" style="display:block; text-align:center;">
                        {{ $locale==='ar'?'تبرع الآن':'Donate Now' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Related --}}
        @if(!empty($related))
        <div class="mt-5">
            <h3 class="section-title mb-4">{{ $locale==='ar'?'حملات أخرى':'Other Campaigns' }}</h3>
            <div class="row">
                @foreach(array_slice($related,0,3) as $rel)
                @php
                    $rg = $rel['goal_amount'] ?? 1;
                    $rr = $rel['raised_amount'] ?? 0;
                    $rp = $rg > 0 ? min(100, round(($rr/$rg)*100)) : 0;
                @endphp
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                        @if(!empty($rel['image']))
                        <a href="{{ url($locale.'/campaigns/'.$rel['id']) }}">
                            <img src="{{ $rel['image'] }}" class="card-img-top" alt="{{ $rel['title']??'' }}" style="height:180px; object-fit:cover;">
                        </a>
                        @endif
                        <div class="card-body">
                            <a href="{{ url($locale.'/campaigns/'.$rel['id']) }}" class="text-decoration-none text-dark">
                                <h6 class="card-title">{{ $rel['title']??'' }}</h6>
                            </a>
                            <div class="progress-container my-2">
                                <div class="progress-bar"><div class="progress-fill" style="width:{{ $rp }}%"></div></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <input type="text" name="amount" class="form-input" placeholder="{{ $locale==='ar'?'المبلغ':'Amount' }}" style="width:60%;">
                                <button type="button" class="btn-donate">{{ $locale==='ar'?'تبرع':'Donate' }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
