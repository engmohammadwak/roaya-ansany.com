@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'تبرع الآن':'Donate Now') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <h1 class="section-title mb-2">{{ $locale==='ar'?'تبرع الآن':'Donate Now' }}</h1>
        <p class="muted-color mb-5">{{ $locale==='ar'?'اختر المشروع الذي تريد دعمه':'Choose a project to support' }}</p>

        <div class="row">
            @forelse($projects['data'] ?? [] as $project)
            @php
                $goal    = $project['goal_amount'] ?? 1;
                $raised  = $project['raised_amount'] ?? 0;
                $percent = $goal > 0 ? min(100, round(($raised/$goal)*100)) : 0;
                $pid     = $project['id'] ?? uniqid();
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="why-donate-card h-100">
                    @if(!empty($project['image']))
                    <img src="{{ $project['image'] }}" class="img-fluid rounded mb-3 w-100" alt="{{ $project['title']??'' }}" style="height:170px; object-fit:cover;">
                    @endif

                    <h5 class="mb-3">{{ $project['title'] ?? '' }}</h5>

                    <div class="progress-container mb-2">
                        <div class="progress-bar"><div class="progress-fill" style="width:{{ $percent }}%"></div></div>
                    </div>

                    <div class="d-flex justify-content-between small text-muted mb-3">
                        <div><div>{{ $locale==='ar'?'الهدف':'Goal' }}</div><strong>${{ number_format($goal) }}</strong></div>
                        <div><div>{{ $locale==='ar'?'المُجمَّع':'Raised' }}</div><strong>${{ number_format($raised) }}</strong></div>
                        <div><div>{{ $locale==='ar'?'المتبقي':'Left' }}</div><strong>${{ number_format(max(0,$goal-$raised)) }}</strong></div>
                    </div>

                    {{-- Quick amounts --}}
                    <div class="d-flex gap-2 flex-wrap mb-3">
                        @foreach([10,25,50,100,250] as $amt)
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="document.getElementById('amt-{{ $pid }}').value={{ $amt }}">{{ $amt }}</button>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between">
                        <input type="text" name="amount" id="amt-{{ $pid }}"
                            value="{{ old('amount', request('amount','10')) }}"
                            class="form-input" style="width:60%;">
                        <button type="button" class="btn-donate">{{ $locale==='ar'?'تبرع':'Donate' }}</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="muted-color fs-5">{{ $locale==='ar'?'لا توجد مشاريع حالياً':'No projects available' }}</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($projects['meta']['last_page']) && $projects['meta']['last_page'] > 1)
        <nav class="d-flex justify-content-center mt-5">
            @for($i = 1; $i <= $projects['meta']['last_page']; $i++)
            <a href="?page={{ $i }}&amount={{ request('amount') }}"
               class="btn {{ request('page',1)==$i ? 'btn-donate' : 'btn-outline-secondary' }} mx-1">{{ $i }}</a>
            @endfor
        </nav>
        @endif
    </div>
</section>
@endsection
