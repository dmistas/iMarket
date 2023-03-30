<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AuthRegistrar implements RouteRegistrar
{

    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function () {
            Route::get('login', [SignInController::class, 'page'])
                ->name('login.page');
            Route::post('/login', [SignInController::class, 'handle'])
                ->middleware('throttle:auth')
                ->name('login.handle');
            Route::delete('/logout', [SignInController::class, 'logout'])
                ->name('logout');

            Route::get('/sign-up', [SignUpController::class, 'page'])
                ->name('register.page');
            Route::post('/sign-up', [SignUpController::class, 'handle'])
                ->middleware('throttle:auth')
                ->name('register.handle');

            Route::get('/forgot-password', [ForgotPasswordController::class, 'page'])
                ->middleware('guest')
                ->name('forgot_password.page');
            Route::post('/forgot-password', [ForgotPasswordController::class, 'handle'])
                ->middleware('guest')
                ->name('forgot_password.handle');

            Route::get('/reset-password/{token}', [ResetPasswordController::class, 'page'])
                ->middleware('guest')
                ->name('password.reset');
            Route::post('/reset-password', [ResetPasswordController::class, 'handle'])
                ->middleware('guest')
                ->name('password.reset.handle');

            Route::get('/auth/socialite/{driver}', [SocialAuthController::class, 'redirect'])
                ->name('socialite.redirect');
            Route::get('/auth/socialite/{driver}/callback', [SocialAuthController::class, 'callback'])
                ->name('socialite.callback');
        });
    }
}
