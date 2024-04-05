@extends('layouts.auth')

@section('title','Вход в аккаунт')

@section('content')
    <div class="max-w-[640px] mt-12 mx-auto p-6 xs:p-8 md:p-12 2xl:p-16 rounded-[20px] bg-purple">
        <h1 class="mb-5 text-lg font-semibold">Вход в аккаунт</h1>
        <form class="space-y-3">
            <input class="w-full h-14 px-4 rounded-lg border border-[#A07BF0] bg-white/20 focus:border-pink focus:shadow-[0_0_0_2px_#EC4176] outline-none transition text-white placeholder:text-white text-xxs md:text-xs font-semibold"
                   placeholder="E-mail"
                   required type="email">
            <input class="w-full h-14 px-4 rounded-lg border border-[#A07BF0] bg-white/20 focus:border-pink focus:shadow-[0_0_0_2px_#EC4176] outline-none transition text-white placeholder:text-white text-xxs md:text-xs font-semibold"
                   placeholder="Пароль"
                   required type="password">
            <button class="w-full btn btn-pink" type="submit">Войти</button>
        </form>
        <div class="space-y-3 mt-5">
            <div class="text-xxs md:text-xs"><a class="text-white hover:text-white/70 font-bold"
                                                href="lost-password.html">Забыли пароль?</a>
            </div>
            <div class="text-xxs md:text-xs"><a class="text-white hover:text-white/70 font-bold"
                                                href="register.html">Регистрация</a>
            </div>
        </div>
        <ul class="flex flex-col md:flex-row justify-between gap-3 md:gap-4 mt-14 md:mt-20">
            <li>
                <a class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium" href="#"
                   rel="noopener" target="_blank">Пользовательское соглашение</a>
            </li>
            <li class="hidden md:block">
                <div class="h-full w-[2px] bg-white/20"></div>
            </li>
            <li>
                <a class="inline-block text-white hover:text-white/70 text-xxs md:text-xs font-medium" href="#"
                   rel="noopener" target="_blank">Политика конфиденциальности</a>
            </li>
        </ul>
    </div>
@endsection
