<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Monkeyzzz')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
@include('partials.nav')
<div class="container">
    @if(Auth::check())
        @include('partials.info')
    @endif
    @yield('content')
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
</body>
</html>