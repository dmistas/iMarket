@extends('layouts.auth')

@section('title', __('Восстановление пароля'))

@section('content')
    <x-forms.auth-forms
        title="Восстановление пароля"
        action="{{ route('password.email') }}"
        method="POST"
    >
        @csrf
        <x-forms.text-input
            name="email"
            type="email"
            placeholder="E-mail"
            required="true"
            value="{{ old('email') }}"
            :is-error="$errors->has('email')"
        ></x-forms.text-input>

        @error('email')
        <x-forms.error>
            {{ $message }}
        </x-forms.error>
        @enderror

        <x-forms.primary-button>
            Отправить
        </x-forms.primary-button>
        <x-slot:socialAuth></x-slot:socialAuth>

        <x-slot:buttons>
            <div class="space-y-3 mt-5">
                <div class="text-xxs md:text-xs"><a href="{{ route('login') }}"
                                                    class="text-white hover:text-white/70 font-bold">Войти в аккаунт</a>
                </div>
            </div>
        </x-slot:buttons>

    </x-forms.auth-forms>
@endsection
