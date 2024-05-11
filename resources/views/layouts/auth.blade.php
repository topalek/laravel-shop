<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css','resources/sass/main.sass', 'resources/js/app.js'])
</head>
<body class="antialiased">
<main class="md:min-h-screen md:flex md:items-center md:justify-center py-16 lg:py-20">
    <div class="container">
        <div class="text-center">
            <a class="inline-block" href="{{route('home')}}" rel="home">
                <img alt="CutCode" class="w-[148px] md:w-[201px] h-[36px] md:h-[50px]" src="{{asset('/images/logo.svg')}}">
            </a>
        </div>
        @include('shared.flash')
        @yield('content')
    </div>
</main>
</body>
</html>
