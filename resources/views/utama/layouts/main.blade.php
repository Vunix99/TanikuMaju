<!DOCTYPE html>
<html lang="id">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, initial-scale=1.0">

@if (!request()->is('/') && !request()->is('registrasi'))
    <title>KawanTani</title>
@endif

    @yield('head') 
</head>

<body>
@if (!request()->is('/') && !request()->is('registrasi'))
    @include('utama.partials.navbar')
@endif

@yield('main')

@if (!request()->is('diskusi*') && !request()->is('/') && !request()->is('registrasi') && !request()->is('diskusi/chat/*') && !request()->is('profil'))
    @include('utama.partials.ctaDiskusi')
@endif


@if (!request()->is('/') && !request()->is('registrasi'))
    @include('utama.partials.footer')
@endif

<!-- Include getFotoNavbar.js only for routes other than '/' and '/registrasi' -->
@if (!request()->is('/') && !request()->is('registrasi'))
    <script src="{{ asset('js/getFotoNavbar.js') }}"></script>
    <script src="{{ asset('js/navbarProfile.js') }}"></script>
@endif

@if (request()->is('/') || request()->is('registrasi'))
    <script src="{{ asset('js/responsiveIndex.js') }}"></script>
@endif


<script src="{{ asset('js/checkSession.js') }}"></script>


</body>
</html>
