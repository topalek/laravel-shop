@extends('layouts.auth')

@section('title','Изменение пароля')

@section('content')
    <x-forms.auth-form title="Сменить пароль" action="" method="post">
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

        <x-forms.text-input
            name="password"
            type="password"
            required
            placeholder="Пароль"/>

        @error('password')
        <x-forms.error>{{$message}}</x-forms.error>
        @enderror

        <x-forms.text-input
            name="password_confirmation"
            type="password"
            required
            placeholder="Повторно пароль"/>

        @error('password_confirmation')
        <x-forms.error>{{$message}}</x-forms.error>
        @enderror

        <x-forms.primary-btn type="submit">Обновить пароль</x-forms.primary-btn>

    </x-forms.auth-form>
@endsection
