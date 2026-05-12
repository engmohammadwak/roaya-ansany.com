@extends('layouts.app')
@php
    $locale  = app()->getLocale();
    $post    = $blog['data'] ?? $blog ?? [];
    $title   = $post['title'] ?? ($locale==='ar'?'المقالة':'Article');
    $content = $post['content'] ?? $post['body'] ?? '';
    $img     = $post['image'] ?? $post['thumbnail'] ?? '';
    $date    = $post['created_at'] ?? $post['date'] ?? '';
    $recents = $recent['data'] ?? [];
@endphp
@section('title', $title . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <div class="row">

            {{-- Article --}}
            <div class="col-lg-8 mb-5">
                @if($img)
                <img src="{{ $img }}" class="img-fluid rounded mb-4 w-100" alt="{{ $title }}" style="max-height:420px; object-fit:cover;">
                @endif

                <h1 class="section-title mb-2">{{ $title }}</h1>
                @if($date)<p class="small muted-color mb-4">{{ $date }}</p>@endif

                <div class="muted-color" style="line-height:2;">{!! $content !!}</div>
            </div>

            {{-- Sidebar Recent Posts --}}
            <div class="col-lg-4">
                <div class="why-donate-card" style="position:sticky; top:90px;">
                    <h5 class="mb-4">{{ $locale==='ar'?'مقالات حديثة':'Recent Articles' }}</h5>
                    @forelse($recents as $rec)
                    <a href="{{ url($locale.'/blogs/'.($rec['slug']??$rec['id'])) }}"
                       class="d-flex align-items-center gap-3 mb-3 text-decoration-none text-dark">
                        @if(!empty($rec['image']))
                        <img src="{{ $rec['image'] }}" alt="" style="width:70px; height:60px; object-fit:cover; border-radius:8px;">
                        @endif
                        <div>
                            <p class="mb-0 small" style="font-weight:600;">{{ Str::limit($rec['title']??'', 55) }}</p>
                            <span class="small muted-color">{{ $rec['created_at']??'' }}</span>
                        </div>
                    </a>
                    @empty
                    <p class="muted-color small">{{ $locale==='ar'?'لا توجد مقالات':'No articles' }}</p>
                    @endforelse

                    <hr class="my-4">

                    {{-- Donate CTA in sidebar --}}
                    <h5 class="mb-3">{{ $locale==='ar'?'ساهم في الخير':'Contribute' }}</h5>
                    <input type="text" name="amount" class="form-input w-100 mb-3"
                        placeholder="{{ $locale==='ar'?'ادخل المبلغ':'Enter amount' }}">
                    <button type="button" class="btn-donate w-100" style="display:block; text-align:center;">
                        {{ $locale==='ar'?'تبرع الآن':'Donate Now' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
