@extends('layouts.auth')

@section('title', __('Восстановление пароля'))

@section('content')
    <x-forms.auth-forms
        title="Восстановление пароля"
        action="{{ route('password.reset.handle') }}"
        method="POST"
    >
        @csrf
        <x-forms.text-input
            name="email"
            type="email"
            value="{{ request('email') }}"
            :is-error="$errors->has('email')"
            placeholder="E-mail"
            required="true"
        ></x-forms.text-input>

        <input type="hidden" name="token" value="{{ $token }}">

        <x-forms.text-input
            name="password"
            type="password"
            :is-error="$errors->has('password')"
            placeholder="Пароль"
            required="true"
        >
        </x-forms.text-input>

        @error('password')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.text-input
            name="password_confirmation"
            type="password"
            :is-error="$errors->has('password_confirmation')"
            placeholder="Подтвердите пароль"
            required="true"
        >
        </x-forms.text-input>


        @error('password_confirmation')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Изменить пароль
        </x-forms.primary-button>

        <x-slot:socialAuth></x-slot:socialAuth>

        <x-slot:buttons></x-slot:buttons>

    </x-forms.auth-forms>
@endsection
