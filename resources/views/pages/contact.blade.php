@extends('layouts.app')
@php $locale = app()->getLocale(); @endphp
@section('title', ($locale==='ar'?'تواصل معنا':'Contact Us') . ' | مؤسسة رؤيا الإنسانية')

@section('content')
<section class="main-section" style="margin-top:80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="section-title mb-5">{{ $locale==='ar'?'تواصل معنا':'Contact Us' }}</h1>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ url($locale.'/contact') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">{{ $locale==='ar'?'الاسم':'Name' }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-input w-100">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ $locale==='ar'?'البريد الإلكتروني':'Email' }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-input w-100">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">{{ $locale==='ar'?'الرسالة':'Message' }}</label>
                        <textarea name="message" rows="6" class="form-input w-100" style="height:auto; resize:vertical;">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn-donate w-100" style="display:block; text-align:center;">
                        {{ $locale==='ar'?'إرسال':'Send Message' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
