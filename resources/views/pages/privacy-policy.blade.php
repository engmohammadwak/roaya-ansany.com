@extends('layouts.app')

@section('title', __('pages.privacy.title'))

@section('content')
<div style="max-width:900px; margin:60px auto; padding:0 20px; line-height:1.9; color:#333;">
    <h1 style="margin-bottom:32px;">{{ __('pages.privacy.title') }}</h1>
    <div id="privacy-content">
        {{-- Content loaded from translations or CMS --}}
        @if(app()->getLocale() === 'ar')
            <p>سياسة الخصوصية - يتم تحديث هذا المحتوى من لوحة التحكم.</p>
        @else
            <p>Privacy Policy - This content is managed from the admin panel.</p>
        @endif
    </div>
</div>
@endsection
