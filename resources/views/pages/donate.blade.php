@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'تبرع الآن':'Donate Now') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <h1 class="section-title mb-5">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</h1>
        <div class="row">
            @forelse($projects['data'] ?? [] as $project)
            @php
                $goal   = $project['goal_amount'] ?? 1;
                $raised = $project['raised_amount'] ?? 0;
                $pct    = $goal > 0 ? min(100, round(($raised/$goal)*100)) : 0;
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="why-donate-card">
                    <h5 class="mb-3">{{ $project['title'] ?? '' }}</h5>
                    <div class="progress-container mb-3">
                        <div class="progress-bar"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mb-3">
                        <div><div>{{ $locale==='ar'?'الهدف':'Goal' }}</div><strong>{{ number_format($goal) }}</strong></div>
                        <div><div>{{ $locale==='ar'?'المُجمَّع':'Raised' }}</div><strong>{{ number_format($raised) }}</strong></div>
                        <div><div>{{ $locale==='ar'?'المتبقي':'Left' }}</div><strong>{{ number_format(max(0,$goal-$raised)) }}</strong></div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        @foreach([10,25,50,100,250] as $amount)
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="document.getElementById('amt-{{ $project['id'] }}').value={{ $amount }}">{{ $amount }}</button>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-between">
                        <input type="text" name="amount" id="amt-{{ $project['id'] }}" value="10" class="form-input" style="width:60%;">
                        <a href="https://app.tujuhbulir.com/projects/{{ $project['id'] }}" target="_blank" class="btn-donate">
                            {{ $locale==='ar'?'تبرع':'Donate' }}
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="muted-color">{{ $locale==='ar'?'لا توجد مشاريع حالياً':'No projects available' }}</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
