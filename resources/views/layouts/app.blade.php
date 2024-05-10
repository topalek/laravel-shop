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
@if($message = flash()->get())
    <div class="{{$message->class()}} p-5">
        {{ $message->message() }}
    </div>
@endif

@yield('content')
</body>
</html>
