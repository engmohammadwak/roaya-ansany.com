@extends('layouts.app')
@php
    $isAr       = $locale === 'ar';
    $p          = $page; // BlogPage model
    $heroCats   = $p ? explode(',', $isAr ? ($p->hero_cats_ar ?? '') : ($p->hero_cats_en ?? '')) : [];
    $heroSub    = $p ? ($isAr ? $p->hero_sub_ar : $p->hero_sub_en) : '';
    $heroPara   = $p ? ($isAr ? $p->hero_para_ar : $p->hero_para_en) : '';
    $secLabel   = $p ? ($isAr ? $p->section_label_ar : $p->section_label_en) : 'مدوّنات رؤيا';
    $secTitle   = $p ? ($isAr ? $p->section_title_ar : $p->section_title_en) : 'رؤيا: حكايات تصنع اللحظة';
@endphp
@section('title', ($isAr ? 'المدونة' : 'Blog') . ' | ' . config('app.name'))
@section('description', $isAr
    ? 'تابع مقالات وقصص مؤسسة رؤيا الإنسانية الملهمة حول العمل الخيري والتأثير الإنساني.'
    : 'Follow inspiring articles and stories from Roaya Insanya about charitable work.')

@section('content')

{{-- ── Hero ── --}}
<div class="first-container">
    <section>
        <div class="container">
            <div class="page-banner secound mt-3">
                <div class="row">
                    {{-- Left: bg image --}}
                    <div class="col-md-6 bg-header" style="background-image: url('{{ asset('website/images/blogs-bg.svg') }}');">
                        <div class="breadcrumbs mt-4 mb-4">
                            <a href="{{ url($locale) }}">
                                <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                                {{ $isAr ? 'الرئيسية' : 'Home' }}
                            </a>
                            <span>/</span>
                            <a href="#" class="active">{{ $isAr ? 'مدوناتنا' : 'Our Blog' }}</a>
                        </div>
                    </div>

                    {{-- Right: content --}}
                    <div class="col-md-6">
                        <div class="stats">
                            <div class="change-life">
                                @if(count(array_filter($heroCats)))
                                <div class="categs mb-4">
                                    @foreach($heroCats as $cat)
                                        @if(trim($cat))
                                        <div class="categ">{{ trim($cat) }}</div>
                                        @endif
                                    @endforeach
                                </div>
                                @endif

                                <h1 class="section-title mb-4">
                                    {{ $heroSub ?: ($isAr ? 'غيّر حياة شخص اليوم بتبرعك' : 'Change a life today with your donation') }}
                                </h1>

                                <p>{{ $heroPara ?: ($isAr ? 'اكتشف قصص المتبرعين والحملات التي تُحدث فرقًا حقيقيًا. انضم إلينا وكن جزءًا من التغيير.' : 'Discover stories of donors and campaigns that make a real difference. Join us.') }}</p>

                                <form action="{{ url($locale.'/donate') }}" class="mt-5">
                                    <div class="row">
                                        <div class="col-8 col-lg-9">
                                            <input type="text" name="amount" class="form-input w-100" placeholder="{{ $isAr ? 'ادخل المبلغ' : 'Enter amount' }}">
                                        </div>
                                        <div class="col-4 col-lg-3">
                                            <button type="submit" class="btn-donate w-100">{{ $isAr ? 'تبرع الآن' : 'Donate Now' }}</button>
                                        </div>
                                        <div class="col-12">
                                            <div class="progress-container mt-4">
                                                <div class="progress-bar">
                                                    <div style="width: 100%;" class="progress-fill"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- ── Posts Section ── --}}
    <section class="main-section">
        <div class="container">
            <div class="blogs">
                <h6 class="mb-4 text-center">{{ $secLabel }}</h6>
                <h2 class="section-title mb-4 text-center">{{ $secTitle }}</h2>

                <div class="row mt-5">
                    <div id="news-list-section">
                        <div id="news-container" class="row row-gap-4 winners_row">
                            @foreach($posts as $post)
                                @php
                                    $img   = $post->image ? asset('storage/'.$post->image) : asset('website/images/stats-card.png');
                                    $title = $isAr ? $post->title_ar : ($post->title_en ?: $post->title_ar);
                                    $date  = $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y');
                                    $slug  = $post->slug;
                                @endphp
                                @include('partials.blog-card', compact('post','img','title','date','slug','locale'))
                            @endforeach
                        </div>

                        <div class="row justify-content-center mt-4">
                            <div class="col-auto text-center" id="news-load-wrap" {{ $hasMore ? '' : 'style=display:none' }}>
                                <p id="news-count-display" class="text-muted mb-3"></p>
                                <div id="news-loading-spinner" class="spinner-border text-primary d-none" role="status">
                                    <span class="visually-hidden">{{ $isAr ? 'جارٍ التحميل...' : 'Loading...' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@push('scripts')
<script>
(function () {
    let offset       = {{ count($posts) }};
    const perPage    = 8;
    let total        = {{ $total }};
    let hasMore      = {{ $hasMore ? 'true' : 'false' }};
    let isLoading    = false;
    const container  = document.getElementById('news-container');
    const spinner    = document.getElementById('news-loading-spinner');
    const countEl    = document.getElementById('news-count-display');
    const wrapEl     = document.getElementById('news-load-wrap');
    const isAr       = {{ $isAr ? 'true' : 'false' }};
    const loadUrl    = "{{ url($locale.'/blogs/load-more') }}";

    function updateCount() {
        const loaded = container.children.length;
        if (loaded < total) {
            countEl.textContent = isAr
                ? `عرض ${loaded} من ${total} مقالات المدونة`
                : `Showing ${loaded} of ${total} articles`;
        } else {
            countEl.textContent = isAr
                ? `عرض جميع ${total} مقالات المدونة`
                : `Showing all ${total} articles`;
            wrapEl && (wrapEl.style.display = 'none');
        }
    }

    function loadMore() {
        if (isLoading || !hasMore) return;
        isLoading = true;
        spinner && spinner.classList.remove('d-none');

        fetch(`${loadUrl}?offset=${offset}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.html) {
                container.insertAdjacentHTML('beforeend', res.html);
                offset += perPage;
            }
            if (res.total_count) total = res.total_count;
            hasMore = !!res.has_more;
            updateCount();
            spinner && spinner.classList.add('d-none');
            isLoading = false;
            if (!hasMore && wrapEl) wrapEl.style.display = 'none';
            if (typeof AOS !== 'undefined') AOS.refreshHard();
        })
        .catch(() => {
            spinner && spinner.classList.add('d-none');
            isLoading = false;
        });
    }

    updateCount();

    window.addEventListener('scroll', function () {
        if (!hasMore) return;
        if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 300) {
            loadMore();
        }
    });
})();
</script>
@endpush
