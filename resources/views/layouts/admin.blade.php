<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'Anasayfa')
    </title>

    <link rel="stylesheet" href="{{ asset('assets/admin/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    @yield('css')
    {{-- @stack('style') --}}
    @stack('style')

    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo/favicon.png') }}" type="image/png">
</head>

<body>
    <div id="app">
        @include('layouts.admin.sidebar')
        <div id="main">

            <div class="page-heading">
                <h3>@yield('title')</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </section>
            </div>


        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/admin/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/extensions/jquery/jquery.min.js') }}"></script> --}}

    @yield('js')
    @stack('javascript')

    <script src="{{ asset('assets/admin/js/custom.js') }}"></script>





</body>

</html>
