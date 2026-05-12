@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'الحملات':'Campaigns') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <h1 class="section-title mb-5">{{ $locale === 'ar' ? 'الحملات' : 'Campaigns' }}</h1>

        <div class="row">
            @forelse($campaigns['data'] ?? [] as $project)
            @php
                $goal    = $project['goal_amount'] ?? 1;
                $raised  = $project['raised_amount'] ?? 0;
                $percent = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
                $imgUrl  = $project['image'] ?? ('https://api.tujuhbulir.com/api/v1/files/project/' . ($project['thumbnail'] ?? ''));
            @endphp
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                    <a href="{{ url($locale.'/campaigns/'.$project['id']) }}">
                        <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $project['title'] ?? '' }}" style="height:200px; object-fit:cover;">
                    </a>
                    <div class="card-body">
                        <a href="{{ url($locale.'/campaigns/'.$project['id']) }}" class="text-decoration-none text-dark">
                            <h5 class="card-title">{{ $project['title'] ?? '' }}</h5>
                        </a>
                        <div class="progress-container my-3">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width:{{ $percent }}%"></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <div>
                                <div>{{ $locale==='ar'?'الهدف':'Goal' }}</div>
                                <strong>{{ number_format($goal) }}</strong>
                            </div>
                            <div>
                                <div>{{ $locale==='ar'?'المُجمَّع':'Raised' }}</div>
                                <strong>{{ number_format($raised) }}</strong>
                            </div>
                            <div>
                                <div>{{ $locale==='ar'?'المتبقي':'Left' }}</div>
                                <strong>{{ number_format(max(0,$goal-$raised)) }}</strong>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <input type="text" name="amount" class="form-input" placeholder="{{ $locale==='ar'?'المبلغ':'Amount' }}" style="width:60%;">
                            <button type="button" class="btn-donate">{{ $locale==='ar'?'تبرع':'Donate' }}</button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="muted-color">{{ $locale==='ar'?'لا توجد حملات حالياً':'No campaigns available' }}</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($campaigns['meta']['last_page']) && $campaigns['meta']['last_page'] > 1)
        <nav class="d-flex justify-content-center mt-4">
            @for($i = 1; $i <= $campaigns['meta']['last_page']; $i++)
            <a href="?page={{ $i }}"
               class="btn {{ request('page',1)==$i ? 'btn-donate' : 'btn-outline-secondary' }} mx-1">
                {{ $i }}
            </a>
            @endfor
        </nav>
        @endif
    </div>
</section>
@endsection
