<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
    <!-- Site Title  -->
    {!! SEO::generate() !!}
    <!-- Bundle and Base CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor.bundle.css?ver=141') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?ver=141') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=141') }}" >
</head>

<body class="body-wider" >
@include('layouts.navbar')
@yield('content')
@include('layouts.footer')
</body>
</html>
