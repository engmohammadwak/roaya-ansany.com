@extends('layouts.app')

@section('title', __('pages.home.title'))

@section('content')

{{-- Hero Slider --}}
<div class="MuiBox-root muirtl-nfh4je">
    <div class="MuiStack-root muirtl-1ogboxe">
        <div class="slick-slider slick-initialized" dir="ltr" id="hero-slider">
            <div class="slick-list">
                <div class="slick-track">
                    @php
                        $slides = $data['sliders'] ?? [];
                        if (empty($slides)) {
                            $slides = [
                                ['image' => asset('assets/slide1.jpg')],
                                ['image' => asset('assets/slide2.jpg')],
                            ];
                        }
                    @endphp
                    @foreach($slides as $slide)
                    <div class="slick-slide" style="width:100%">
                        <div>
                            <img class="MuiBox-root" src="{{ $slide['image'] ?? asset('assets/default-slide.jpg') }}"
                                 alt="slide" style="width:100%; max-height:600px; object-fit:cover;">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Featured Projects --}}
<div class="MuiStack-root muirtl-1axu09g" style="padding: 40px 20px; max-width:1200px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <p class="MuiTypography-root muirtl-yy6mwj">{{ __('pages.home.latest_projects') }}</p>
        <a href="{{ route('campaigns', app()->getLocale()) }}" class="MuiTypography-root muirtl-186zx29">
            {{ __('pages.home.see_all') }}
        </a>
    </div>

    <div id="projects-slider" class="slick-slider slick-initialized">
        <div class="slick-list">
            <div class="slick-track">
                @forelse($projects['data'] ?? [] as $project)
                <div class="slick-slide" style="padding:0 8px;">
                    <div class="MuiBox-root muirtl-1tf49gn" style="display:inline-block; width:100%;">
                        <div class="MuiStack-root muirtl-gii6a9">
                            <div class="MuiStack-root muirtl-j7qwjs">
                                {{-- Project Image --}}
                                <a href="{{ route('campaigns.show', [app()->getLocale(), $project['id']]) }}"
                                   style="text-decoration:none; height:170px; display:block;">
                                    <img class="MuiBox-root muirtl-4wc2e4"
                                         src="{{ $project['image'] ?? 'https://api.tujuhbulir.com/api/v1/files/project/' . ($project['thumbnail'] ?? '') }}"
                                         alt="{{ $project['title'] ?? '' }}"
                                         style="width:100%; height:170px; object-fit:cover; border-radius:8px;">
                                </a>
                            </div>

                            {{-- Project Info --}}
                            <div class="MuiStack-root muirtl-s9ykac" style="padding:12px;">
                                <a href="{{ route('campaigns.show', [app()->getLocale(), $project['id']]) }}"
                                   style="text-decoration:none;">
                                    <h3 class="MuiTypography-root muirtl-1l0mb2o">
                                        {{ $project['title'] ?? '' }}
                                    </h3>
                                </a>

                                {{-- Progress Bar --}}
                                @php
                                    $goal = $project['goal_amount'] ?? 1;
                                    $raised = $project['raised_amount'] ?? 0;
                                    $percent = $goal > 0 ? min(100, round(($raised / $goal) * 100)) : 0;
                                @endphp
                                <span class="MuiLinearProgress-root MuiLinearProgress-colorPrimary MuiLinearProgress-determinate muirtl-d01cuw"
                                      role="progressbar" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                    <span class="MuiLinearProgress-bar muirtl-118fe6a"
                                          style="transform: translateX(-{{ 100 - $percent }}%)"></span>
                                </span>

                                {{-- Stats --}}
                                <div style="display:flex; justify-content:space-between; margin-top:8px; font-size:13px;">
                                    <div>
                                        <p style="color:#888;">{{ __('projects.goal') }}</p>
                                        <p>{{ number_format($goal) }}</p>
                                    </div>
                                    <div>
                                        <p style="color:#888;">{{ __('projects.raised') }}</p>
                                        <p>{{ number_format($raised) }}</p>
                                    </div>
                                    <div>
                                        <p style="color:#888;">{{ __('projects.remaining') }}</p>
                                        <p>{{ number_format(max(0, $goal - $raised)) }}</p>
                                    </div>
                                </div>

                                {{-- Donate Button --}}
                                <a href="{{ route('donate', app()->getLocale()) }}?project={{ $project['id'] }}"
                                   class="MuiButtonBase-root MuiButton-root MuiButton-contained MuiButton-containedInherit MuiButton-fullWidth muirtl-zqbx1x"
                                   style="margin-top:12px; display:flex; align-items:center; justify-content:center; gap:8px;">
                                    <img src="{{ asset('assets/donate.svg') }}" alt="donate" class="icon-white" style="width:18px;">
                                    {{ __('projects.donate_now') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p style="text-align:center; color:#888; padding:40px;">{{ __('projects.no_projects') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('#hero-slider').slick({
        autoplay: true,
        autoplaySpeed: 4000,
        dots: true,
        arrows: true,
        rtl: {{ app()->getLocale() === 'ar' ? 'true' : 'false' }}
    });

    $('#projects-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        dots: false,
        arrows: true,
        rtl: {{ app()->getLocale() === 'ar' ? 'true' : 'false' }},
        responsive: [
            { breakpoint: 900, settings: { slidesToShow: 2 } },
            { breakpoint: 600, settings: { slidesToShow: 1 } }
        ]
    });
});
</script>
@endpush
