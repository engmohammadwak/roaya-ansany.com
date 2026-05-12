@extends('layouts.app')
@php $locale = app()->getLocale(); $isAr = $locale === 'ar'; @endphp
@section('title', ($isAr ? 'البرامج' : 'Programs') . ' | مؤسسة رؤيا الإنسانية')
@push('styles')
<style>
.programs-hero { background:linear-gradient(135deg,#1a7a4a,#2ecc71); padding:100px 0 60px; color:#fff; text-align:center; }
.programs-hero h1 { font-size:2.5rem; font-weight:700; }
.programs-section { padding:70px 0; background:#f8fffe; }
.filter-tabs { display:flex; gap:10px; flex-wrap:wrap; justify-content:center; margin-bottom:40px; }
.filter-btn { padding:8px 22px; border-radius:50px; border:2px solid #1a7a4a; color:#1a7a4a; background:#fff; cursor:pointer; font-weight:600; transition:all .3s; font-size:.9rem; }
.filter-btn.active, .filter-btn:hover { background:#1a7a4a; color:#fff; }
.program-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,.07); transition:transform .3s; height:100%; }
.program-card:hover { transform:translateY(-5px); }
.program-card img { width:100%; height:200px; object-fit:cover; }
.program-card-body { padding:22px; }
.program-icon { font-size:2rem; margin-bottom:10px; }
.program-card-body h4 { font-weight:700; color:#222; margin-bottom:10px; }
.program-card-body p { color:#666; font-size:.9rem; line-height:1.7; }
.program-tag { display:inline-block; background:#e8f5ee; color:#1a7a4a; padding:3px 12px; border-radius:20px; font-size:.8rem; font-weight:600; margin-bottom:12px; }
.breadcrumb-section { background:#f0faf5; padding:12px 0; border-bottom:1px solid #d4edda; }
.breadcrumb-section a { color:#1a7a4a; text-decoration:none; }
</style>
@endpush
@section('content')
<div class="breadcrumb-section">
    <div class="container"><small><a href="{{ url($locale.'/') }}">{{ $isAr?'الرئيسية':'Home' }}</a><span style="margin:0 8px;color:#888">›</span><span class="text-muted">{{ $isAr?'البرامج':'Programs' }}</span></small></div>
</div>
<section class="programs-hero">
    <div class="container">
        <h1>{{ $isAr ? 'برامجنا' : 'Our Programs' }}</h1>
        <p style="opacity:.9;margin-top:10px">{{ $isAr?'تعرّف على برامجنا الإنسانية المتنوعة':'Explore our diverse humanitarian programs' }}</p>
    </div>
</section>
<section class="programs-section">
    <div class="container">
        @if(($isAr ? $categories_ar : $categories_en)->count() > 0)
        <div class="filter-tabs">
            <button class="filter-btn active" data-filter="all">{{ $isAr?'الكل':'All' }}</button>
            @foreach($isAr ? $categories_ar : $categories_en as $cat)
                <button class="filter-btn" data-filter="{{ Str::slug($cat) }}">{{ $cat }}</button>
            @endforeach
        </div>
        @endif
        <div class="row g-4" id="programs-grid">
            @forelse($programs as $program)
            <div class="col-md-6 col-lg-4 program-item" data-cat="{{ Str::slug($isAr ? $program->category_ar : $program->category_en) }}">
                <div class="program-card">
                    @if($program->image)
                        <img src="{{ Storage::url($program->image) }}" alt="{{ $isAr?$program->title_ar:$program->title_en }}">
                    @endif
                    <div class="program-card-body">
                        @if($program->icon)<div class="program-icon">{{ $program->icon }}</div>@endif
                        @if($program->category_ar)
                        <span class="program-tag">{{ $isAr?$program->category_ar:$program->category_en }}</span>
                        @endif
                        <h4>{{ $isAr?$program->title_ar:$program->title_en }}</h4>
                        @if($program->description_ar)
                        <p>{{ $isAr?$program->description_ar:$program->description_en }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">{{ $isAr?'لا توجد برامج حالياً':'No programs available' }}</div>
            @endforelse
        </div>
        @if($programs->hasPages())
        <div class="d-flex justify-content-center mt-5">{{ $programs->links() }}</div>
        @endif
    </div>
</section>
@push('scripts')
<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        document.querySelectorAll('.program-item').forEach(item => {
            item.style.display = (filter === 'all' || item.dataset.cat === filter) ? '' : 'none';
        });
    });
});
</script>
@endpush
@endsection
