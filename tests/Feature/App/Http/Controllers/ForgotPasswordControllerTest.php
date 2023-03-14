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
    private array $testCredentional = ['email' => 'wrong_email@mail.ru'];

    public function test_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertSee('Восстановление пароля')
            ->assertViewIs('auth.forgot-password');
    }

    public function test_it_handle_success(): void
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

    public function test_it_handle_fail(): void
    {
        $this->assertDatabaseMissing('users', $this->testCredentional);

        $this->post(action([ForgotPasswordController::class, 'handle']), $this->testCredentional)
            ->assertInvalid('email');

        Notification::assertNothingSent();
    }
}
