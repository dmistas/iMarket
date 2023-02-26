<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Requests\ForgotPasswordFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    public function test_it_forgot_page_success()
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertSee('Восстановление пароля')
            ->assertViewIs('auth.forgot-password');
    }

    public function test_forgot_password_send_email_success()
    {
        Event::fake();
        Notification::fake();

        $user = UserFactory::new()->create([
            'email' => 'test@mail.ru',
        ]);

        $request = ForgotPasswordFormRequest::factory()->create([
            'email' => $user->email,
        ]);

        $response = $this->post(action([ForgotPasswordController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }
}
