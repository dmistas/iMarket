<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\ForgotPasswordFormRequest;
use App\Http\Requests\ResetPasswordFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;
use function route;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class AuthControllerTest extends TestCase
{
    public function test_it_login_page_success()
    {
        $this->get(action([AuthController::class, 'index']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.index');
    }

    public function test_it_signe_up_page_success()
    {
        $this->get(action([AuthController::class, 'signUp']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    public function test_it_forgot_page_success()
    {
        $this->get(action([AuthController::class, 'forgot']))
            ->assertOk()
            ->assertSee('Восстановление пароля')
            ->assertViewIs('auth.forgot-password');
    }

    public function test_is_store_success()
    {
        Event::fake();
        Notification::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'test@mail.ru',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $response = $this->post(route('store'), $request);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'email' => $request['email'],
        ]);

        /**
         * @var Authenticatable $user
         */
        $user = User::query()->where(['email' => $request['email']])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $response->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_sign_in_success()
    {
        $password = '123456789';

        $user = User::factory()->create([
            'password' => bcrypt($password),
            'email' => 'test@mail.ru',
        ]);

        $request = SignInFormRequest::factory()
            ->create([
                'email' => $user->email,
                'password' => $password,
            ]);
        $response = $this->post(action([AuthController::class, 'signIn']), $request);

        $response->assertValid()
            ->assertRedirectToRoute('home');

        $this->assertAuthenticatedAs($user);

    }

    public function test_logout_success()
    {
        $user = User::factory()->create([
            'email' => 'test@mail.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([AuthController::class, 'logout']));

        $this->assertGuest();
    }

    public function test_forgot_password_send_email_success()
    {
        Event::fake();
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@mail.ru',
        ]);

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->post(action([AuthController::class, 'forgotPassword']), $request);

        $response->assertValid()
            ->assertSessionHas('message', __(Password::RESET_LINK_SENT))
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    public function test_reset_password_success()
    {
        Event::fake();
        $user = User::factory()->create([
            'email' => 'test@mail.ru',
        ]);
        $token = Password::createToken($user);

        $request = ResetPasswordFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'token' => $token,
        ]);

        $response = $this->post(action([AuthController::class, 'resetPassword']), $request);

        $response->assertValid()
            ->assertSessionHas('message', __(Password::PASSWORD_RESET))
            ->assertRedirect(route('login'));

        Event::assertDispatched(PasswordReset::class);

    }

}
