@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'من نحن':'About Us') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <h1 class="section-title mb-5">{{ $locale==='ar'?'من نحن':'About Us' }}</h1>
        @if(!empty($data))
            @foreach((array)$data as $section)
            <div class="mb-5">
                @if(isset($section['title']))<h2 class="section-title mb-3">{{ $section['title'] }}</h2>@endif
                @if(isset($section['image']))<img src="{{ $section['image'] }}" class="img-fluid rounded mb-3" alt="">@endif
                @if(isset($section['content']))<div class="muted-color" style="line-height:1.9">{!! $section['content'] !!}</div>@endif
            </div>
            @endforeach
        @else
        <div class="row">
            <div class="col-md-6">
                <p class="muted-color" style="line-height:1.9">
                    {{ $locale==='ar' ? 'مؤسسة رؤيا الإنسانية هي مؤسسة أهلية غير ربحية تعمل في إطار القوانين التركية، وتُعنى بتقديم خدمات إنسانية وإغاثية تستهدف الفئات الأكثر هشاشة.' : 'Roaya Insanya is a non-profit organization operating under Turkish law, providing humanitarian and relief services targeting the most vulnerable groups.' }}
                </p>
            </div>
            <div class="col-md-6">
                <img src="https://roaya-ansany.com/storage/uploads/pages/dWfpjiaOmZUcA0BC2wvyPZotctgE6L3TwskmdcsO.jpg" class="img-fluid rounded" alt="about">
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
