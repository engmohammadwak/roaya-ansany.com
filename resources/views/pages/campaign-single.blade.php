@extends('layouts.app')
@php
    $locale  = app()->getLocale();
    $isAr    = $locale === 'ar';
    $goal    = (float) $campaign->target_amount;
    $raised  = (float) $campaign->collected_amount;
    $left    = max(0, $goal - $raised);
    $percent = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
@endphp
@section('title', $campaign->title . ' | ' . config('app.name'))
@section('meta_description', Str::limit(strip_tags($campaign->description), 160))

@section('content')

<main class="campaign first-container">

    {{-- ===== BANNER ===== --}}
    <section class="blank-banner position-relative">
        <div class="container">

            <div class="breadcrumbs">
                <a class="color-de" href="{{ url($locale) }}">
                    <img class="me-2" src="{{ asset('website/images/home.svg') }}" alt="home">
                    {{ $isAr ? 'الرئيسية' : 'Home' }}
                </a>
                <span class="color-de">/</span>
                <a class="color-de" href="{{ url($locale . '/campaigns') }}">
                    {{ $isAr ? 'الحملات' : 'Campaigns' }}
                </a>
                <span class="color-de">/</span>
                <span class="color-de">تفاصيل الحملة</span>
            </div>

            <h1 class="section-title text-white mt-4 col-lg-7 col-md-12">
                {{ $campaign->title }}
            </h1>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <p class="color-eb mt-4">
                        {{ Str::limit(strip_tags($campaign->description), 120) }}
                    </p>
                </div>
            </div>

            {{-- Stats + Progress in banner --}}
            <div class="row">
                <div class="col-lg-6 col-md-12">

                    {{-- Raised / Goal / Left --}}
                    <div class="d-flex justify-content-between text-white mb-2 mt-4" style="font-size:.9rem;">
                        <div>
                            <div class="opacity-75">{{ $isAr ? 'المستهدف' : 'Goal' }}</div>
                            <strong>${{ number_format($goal, 0) }}</strong>
                        </div>
                        <div class="text-center">
                            <div class="opacity-75">{{ $isAr ? 'تم جمعه' : 'Raised' }}</div>
                            <strong>${{ number_format($raised, 0) }}</strong>
                        </div>
                        <div class="text-end">
                            <div class="opacity-75">{{ $isAr ? 'المتبقي' : 'Left' }}</div>
                            <strong>${{ number_format($left, 0) }}</strong>
                        </div>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="progress-container">
                        <div class="progress-bar">
                            <div style="width: {{ $percent }}%;" class="progress-fill"></div>
                        </div>
                    </div>

                    {{-- Percentage label --}}
                    <p class="text-white mt-2" style="font-size:.85rem; opacity:.85;">
                        {{ $percent }}% {{ $isAr ? 'من الهدف' : 'of goal' }}
                    </p>

                </div>
            </div>

        </div>
    </section>

    {{-- ===== MAIN BODY ===== --}}
    <div class="d-flex flex-column">

        {{-- Donation Card --}}
        <section class="campaign-section order-2 w-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12 d-none d-lg-block"></div>
                    <div class="col-lg-5 col-md-12">
                        <div class="card-wrapper">
                            <div class="donation-card">

                                <img src="{{ $campaign->image_url }}" alt="{{ $campaign->title }}">

                                <div class="donation-content mt-4">

                                    {{-- Stats inside card --}}
                                    <div class="d-flex justify-content-between mb-3" style="font-size:.88rem;">
                                        <div>
                                            <div class="muted-color">{{ $isAr ? 'المستهدف' : 'Goal' }}</div>
                                            <strong class="dark-text-color">${{ number_format($goal, 0) }}</strong>
                                        </div>
                                        <div class="text-center">
                                            <div class="muted-color">{{ $isAr ? 'تم جمعه' : 'Raised' }}</div>
                                            <strong class="main-color">${{ number_format($raised, 0) }}</strong>
                                        </div>
                                        <div class="text-end">
                                            <div class="muted-color">{{ $isAr ? 'المتبقي' : 'Left' }}</div>
                                            <strong class="dark-text-color">${{ number_format($left, 0) }}</strong>
                                        </div>
                                    </div>

                                    {{-- Progress bar in card --}}
                                    <div class="progress-container mb-1">
                                        <div class="progress-bar">
                                            <div style="width: {{ $percent }}%;" class="progress-fill"></div>
                                        </div>
                                    </div>
                                    <p class="muted-color mb-4" style="font-size:.82rem;">{{ $percent }}% {{ $isAr ? 'من الهدف' : 'of goal' }}</p>

                                    <h2>{{ $isAr ? 'اختر مبلغ التبرع الخاص بك' : 'Choose Your Donation Amount' }}</h2>

                                    <div class="amounts mt-3">
                                        @foreach([5, 10, 15, 20, 25] as $i => $amt)
                                        <div>
                                            <input {{ $i === 0 ? 'checked' : '' }} type="radio"
                                                name="select-amount" id="amount{{ $amt }}"
                                                class="filter-check" hidden>
                                            <label for="amount{{ $amt }}" class="filter-btn">
                                                <p>{{ $amt }}</p>
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>

                                    <p class="dark-text-color mt-4 mb-3">
                                        {{ $isAr ? 'تخصيص مبلغ للتبرع' : 'Custom Amount' }}
                                    </p>
                                    <input class="form-input w-100" type="text" name="amount"
                                        placeholder="{{ $isAr ? 'ادخل مبلغ آخر' : 'Enter another amount' }}">

                                    <div class="mt-4 mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmData">
                                            <label class="form-check-label dark-text-color" for="confirmData">
                                                {{ $isAr ? 'بإتمام التبرع أنت توافق على' : 'By donating you agree to' }}
                                                <a href="{{ url($locale . '/terms-and-conditions') }}" class="main-color">
                                                    {{ $isAr ? 'سياسات التبرع كاملة' : 'full donation policies' }}
                                                </a>
                                            </label>
                                        </div>
                                    </div>

                                    <a href="#" class="btn-donate text-center w-100 mt-4">
                                        {{ $isAr ? 'تبرع الآن' : 'Donate Now' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Campaign Details --}}
        <section class="main-section mt-5 mt-lg-unset order-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-12">
                        <p class="dark-text-color fw-bold">
                            {{ $isAr ? 'تفاصيل الحملة' : 'Campaign Details' }}
                        </p>
                        <div class="color-444 mt-3">
                            {!! $campaign->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    {{-- ===== RELATED CAMPAIGNS ===== --}}
    @if($related->count())
    <section class="mt-5">
        <div class="container">
            <h3 class="section-title mb-4">{{ $isAr ? 'حملات أخرى' : 'Other Campaigns' }}</h3>
            <div class="row g-4">
                @foreach($related as $rel)
                @php
                    $rGoal    = (float) $rel->target_amount;
                    $rRaised  = (float) $rel->collected_amount;
                    $rLeft    = max(0, $rGoal - $rRaised);
                    $rPercent = $rGoal > 0 ? min(100, round(($rRaised / $rGoal) * 100)) : 0;
                @endphp
                <div class="col-lg-4 col-md-6">
                    <div class="campaign-card">
                        <a href="{{ url($locale . '/campaigns/' . ($rel->slug ?? $rel->id)) }}" class="blog-card">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="img-fluid mb-0">
                            <div class="title">
                                <h3 class="dark-text-color mt-2">{{ $rel->title }}</h3>
                            </div>
                            {{-- Related stats --}}
                            <div class="d-flex justify-content-between mt-3 mb-1" style="font-size:.8rem;">
                                <span class="muted-color">{{ $isAr ? 'تم جمعه' : 'Raised' }}: <strong class="main-color">${{ number_format($rRaised, 0) }}</strong></span>
                                <span class="muted-color">{{ $rPercent }}%</span>
                                <span class="muted-color">{{ $isAr ? 'الهدف' : 'Goal' }}: <strong>${{ number_format($rGoal, 0) }}</strong></span>
                            </div>
                            <div class="progress-container mt-1">
                                <div class="progress-bar gray">
                                    <div style="width: {{ $rPercent }}%;" class="progress-fill"></div>
                                </div>
                            </div>
                            <div class="card-footer mt-3">
                                <input type="text" name="amount" class="form-input"
                                    placeholder="{{ $isAr ? 'ادخل مبلغ التبرع' : 'Donation amount' }}">
                                <button type="button" class="btn-donate">{{ $isAr ? 'تبرع' : 'Donate' }}</button>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</main>

@endsection
