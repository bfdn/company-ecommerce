@extends('layouts.front')
@section('title')
    {{ $page_title }}
@endsection

@section('meta')
    <meta name="description" content="{{ isset($item) ? $item->seo_description : 'Üye Ol' }}">
    <meta name="keywords" content="{{ isset($item) ? $item->seo_keywords : 'Üye Ol' }}">
@endsection
@section('css')
@endsection
@push('style')
@endpush




@section('content')
    <x-front.breadcrumb :breadcrumbs="$breadcrumbs ?? ''" />

    <!-- create account-in Section Start  -->
    <section class="create-account section section--xl" id="loginAction" data-login="{{ route('front.login') }}">
        <div class="container">
            <div class="form-wrapper">

                @if ($message)
                    <div class="alert alert-{{ $message['type'] }}">{!! $message['text'] !!}</div>
                @endif


            </div>
        </div>
    </section>
    <!-- create account-in Section end  -->
@endsection




@section('js')
    <script>
        setTimeout(() => {
            location.href = $('#loginAction').data('login');
        }, 5000);
    </script>
@endsection
@push('javascript')
@endpush
