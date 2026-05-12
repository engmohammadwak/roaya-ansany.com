@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'المدونة':'Blog') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <h1 class="section-title mb-5">{{ $locale==='ar'?'المدونة':'Blog' }}</h1>
        <div class="row">
            @forelse($blogs['data'] ?? [] as $blog)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">
                    @if(!empty($blog['image']))
                    <a href="{{ url($locale.'/blogs/'.($blog['slug']??$blog['id'])) }}">
                        <img src="{{ $blog['image'] }}" class="card-img-top" alt="{{ $blog['title']??'' }}" style="height:200px; object-fit:cover;">
                    </a>
                    @endif
                    <div class="card-body">
                        <a href="{{ url($locale.'/blogs/'.($blog['slug']??$blog['id'])) }}" class="text-decoration-none text-dark">
                            <h5 class="card-title">{{ $blog['title']??'' }}</h5>
                        </a>
                        <p class="muted-color small">{{ Str::limit(strip_tags($blog['excerpt']??$blog['content']??''), 120) }}</p>
                        <p class="small text-muted">{{ $blog['created_at']??'' }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="muted-color">{{ $locale==='ar'?'لا توجد مقالات حالياً':'No articles available' }}</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
