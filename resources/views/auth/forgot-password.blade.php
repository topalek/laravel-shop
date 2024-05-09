@extends('layouts.auth')

@section('title','Восстановление пароля')

@section('content')
    <x-forms.auth-form title="Забыли пароль" action="{{route('forgot.handle')}}" method="post">
        @csrf
        <x-forms.text-input
            name="email"
            type="email"
            required
            placeholder="E-mail"
            value="{{old('email')}}"
            :isError="$errors->has('email')"/>
        @error('email')
        <x-forms.error>{{$message}}</x-forms.error>
        @enderror


        <x-forms.primary-btn type="submit">Отправить</x-forms.primary-btn>

        <x-slot:socialAuth>
            <ul class="space-y-3 mt-4">
                <li>
                    <a class="relative flex items-center h-14 px-12 rounded-lg border border-[#A07BF0] bg-white/20 hover:bg-white/20 active:bg-white/10 active:translate-y-0.5"
                       href="{{route('socialite.redirect',['driver' => 'github'])}}">
                        <svg class="shrink-0 absolute left-4 w-5 sm:w-6 h-5 sm:h-6" fill="currentColor"
                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd"
                                  d="M10 0C4.475 0 0 4.475 0 10a9.994 9.994 0 0 0 6.838 9.488c.5.087.687-.213.687-.476 0-.237-.013-1.024-.013-1.862-2.512.463-3.162-.612-3.362-1.175-.113-.287-.6-1.175-1.025-1.412-.35-.188-.85-.65-.013-.663.788-.013 1.35.725 1.538 1.025.9 1.512 2.337 1.087 2.912.825.088-.65.35-1.088.638-1.338-2.225-.25-4.55-1.112-4.55-4.937 0-1.088.387-1.987 1.025-2.688-.1-.25-.45-1.274.1-2.65 0 0 .837-.262 2.75 1.026a9.28 9.28 0 0 1 2.5-.338c.85 0 1.7.112 2.5.337 1.912-1.3 2.75-1.024 2.75-1.024.55 1.375.2 2.4.1 2.65.637.7 1.025 1.587 1.025 2.687 0 3.838-2.337 4.688-4.562 4.938.362.312.675.912.675 1.85 0 1.337-.013 2.412-.013 2.75 0 .262.188.574.688.474A10.017 10.017 0 0 0 20 10c0-5.525-4.475-10-10-10Z"
                                  fill-rule="evenodd"/>
                        </svg>
                        <span class="grow text-xxs md:text-xs font-bold text-center">Войти с помощью GitHub</span>
                    </a>
                </li>
            </ul>
        </x-slot:socialAuth>
        <x-slot:buttons>
            <div class="flex justify-between mt-5">
                <div class="text-xxs md:text-xs">
                    <a class="text-white hover:text-white/70 font-bold" href="{{route('login.page')}}">Вспомнили
                        пароль?</a>
                </div>
            </div>

        </x-slot:buttons>

    </x-forms.auth-form>
@endsection
