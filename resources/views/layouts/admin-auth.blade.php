<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yönetim Paneli')</title>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/main/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/pages/auth.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/admin/images/logo/favicon.png') }}" type="image/png">

    @yield('css')
</head>

<body>
    <div id="auth">

        @yield('content')

    </div>

    @yield('js')
</body>

</html>
