@extends('layouts.app')

@section('title', __('pages.terms.title'))

@section('content')
<div style="max-width:900px; margin:60px auto; padding:0 20px; line-height:1.9; color:#333;">
    <h1 style="margin-bottom:32px;">{{ __('pages.terms.title') }}</h1>
    <div id="terms-content">
        @if(app()->getLocale() === 'ar')
            <p>الشروط والأحكام - يتم تحديث هذا المحتوى من لوحة التحكم.</p>
        @else
            <p>Terms and Conditions - This content is managed from the admin panel.</p>
        @endif
    </div>
</div>
@endsection
