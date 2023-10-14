<!doctype html>
<html lang="en">

<head>
    <title> @yield('title', 'Anasayfa')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    {{-- <meta name="description" content="Demo powered by Templatetrip"> --}}
    {{-- <meta name="author" content=""> --}}


    <link rel="icon" type="image/png" href="{{ asset('assets/front/images/favicon/favicon-16x16.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/lib/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/lib/css/bvselect.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/lib/css/venobox.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/lib/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" />

    <style>
        .header__navigation-menu-link.lang {
            padding: 0;
        }

        .header__navigation-menu-link.lang:hover a {
            color: #999999;
        }
    </style>

    @yield('css')
    @stack('style')

    <!-- Custom styles for this template -->
</head>

<body class="index layout1">

    @include('layouts.front.header')

    <main>
        @yield('content')
    </main>


    @include('layouts.front.footer')




    <script src="{{ asset('assets/front/lib/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/front/lib/js/venobox.min.js') }}"></script>
    <script src="{{ asset('assets/front/lib/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/lib/js/bvselect.js') }}"></script>
    <script src="{{ asset('assets/front/lib/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/lib/js/jquery.syotimer.min.js') }}"></script>

    @yield('js')
    @stack('javascript')

    {{-- <script src="{{ asset('assets/front/js/main.js') }}"></script> --}}
    <script src="{{ asset('assets/front/js/main-yeni.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>
    {{-- <script src="{{ asset('assets/front/js/home1.js') }}"></script> --}}

</body>

</html>
