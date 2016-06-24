<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Monkeyzzz')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
</head>
<body>
@include('partials.nav')
<div class="container">
    <div class="row">
        <div class="col-md-2">
            @if(Auth::check())
                @include('partials.info')
            @endif
        </div>
        <div class="col-md-10">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>