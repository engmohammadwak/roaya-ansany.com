@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? '\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639' : 'Projects') . ' | \u0645\u0624\u0633\u0633\u0629 \u0631\u0624\u064a\u0627 \u0627\u0644\u0625\u0646\u0633\u0627\u0646\u064a\u0629')
@push('styles')
<style>
.projects-hero { background:linear-gradient(135deg,#1a7a4a,#2ecc71); padding:100px 0 60px; color:#fff; text-align:center; }
.projects-hero h1 { font-size:2.5rem; font-weight:700; }
.projects-section { padding:70px 0; background:#f8fffe; }
.project-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.07); transition:transform .3s,box-shadow .3s; height:100%; }
.project-card:hover { transform:translateY(-5px); box-shadow:0 10px 35px rgba(26,122,74,.15); }
.project-card img { width:100%; height:210px; object-fit:cover; }
.project-card-body { padding:22px; }
.project-card-body h4 { font-weight:700; color:#222; margin-bottom:8px; }
.project-country { font-size:.85rem; color:#888; margin-bottom:14px; }
.progress-wrap { background:#e9ecef; border-radius:50px; height:8px; margin:12px 0; }
.progress-fill { background:linear-gradient(90deg,#1a7a4a,#2ecc71); height:8px; border-radius:50px; transition:width .6s; }
.project-stats { display:flex; justify-content:space-between; font-size:.85rem; color:#666; margin-bottom:16px; }
.project-stats strong { color:#1a7a4a; display:block; font-size:1rem; }
.btn-donate-card { background:linear-gradient(135deg,#1a7a4a,#2ecc71); color:#fff; border:none; padding:10px 25px; border-radius:50px; font-weight:600; width:100%; transition:opacity .3s; cursor:pointer; }
.btn-donate-card:hover { opacity:.9; }
.breadcrumb-section { background:#f0faf5; padding:12px 0; border-bottom:1px solid #d4edda; }
.breadcrumb-section a { color:#1a7a4a; text-decoration:none; }
</style>
@endpush
@section('content')
<div class="breadcrumb-section">
    <div class="container"><small><a href="{{ url($locale.'/') }}">{{ $isAr?'\u0627\u0644\u0631\u0626\u064a\u0633\u064a\u0629':'Home' }}</a><span style="margin:0 8px;color:#888">\u203a</span><span class="text-muted">{{ $isAr?'\u0627\u0644\u0645\u0634\u0627\u0631\u064a\u0639':'Projects' }}</span></small></div>
</div>
<section class="projects-hero">
    <div class="container">
        <h1>{{ $heroTitle }}</h1>
        @if($heroDesc)
        <p style="opacity:.9;margin-top:10px">{{ $heroDesc }}</p>
        @endif
    </div>
</section>
<section class="projects-section">
    <div class="container">
        <div class="row g-4">
            @forelse($projects as $project)
            @php
                $goal   = $project->goal_amount ?: 1;
                $raised = $project->raised_amount;
                $pct    = min(100, round(($raised / $goal) * 100));
            @endphp
            <div class="col-md-6 col-lg-4">
                <div class="project-card">
                    @if($project->image)
                    <img src="{{ Storage::url($project->image) }}" alt="{{ $isAr?$project->title_ar:$project->title_en }}">
                    @endif
                    <div class="project-card-body">
                        <h4>{{ $isAr?$project->title_ar:$project->title_en }}</h4>
                        @if($project->country_ar)
                        <p class="project-country">\ud83d\udccd {{ $isAr?$project->country_ar:$project->country_en }}</p>
                        @endif
                        <div class="progress-wrap"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>
                        <div class="project-stats">
                            <div><span>{{ $isAr?'\u0627\u0644\u0647\u062f\u0641':'Goal' }}</span><strong>{{ number_format($goal) }}</strong></div>
                            <div><span>{{ $isAr?'\u0627\u0644\u0645\u064f\u062c\u0645\u064e\u0651\u0639':'Raised' }}</span><strong>{{ number_format($raised) }}</strong></div>
                            <div><span>{{ $isAr?'\u0627\u0644\u0645\u062a\u0628\u0642\u064a':'Left' }}</span><strong>{{ number_format(max(0,$goal-$raised)) }}</strong></div>
                        </div>
                        <button class="btn-donate-card">{{ $isAr?'\u062a\u0628\u0631\u0639 \u0627\u0644\u0622\u0646':'Donate Now' }}</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">{{ $isAr?'\u0644\u0627 \u062a\u0648\u062c\u062f \u0645\u0634\u0627\u0631\u064a\u0639 \u062d\u0627\u0644\u064a\u064b\u0627':'No projects available' }}</div>
            @endforelse
        </div>
        @if($projects->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $projects->links() }}</div>
        @endif
    </div>
</section>
@endsection
