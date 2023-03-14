<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\ResetPasswordFormRequest;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::new()->create();
        $this->token = Password::createToken($this->user);
    }

    public function test_it_page_success(): void
    {
        $this->get(route('password.reset', ['token' => $this->token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    public function test_it_handle_success(): void
    {
        $password = '1234567890';
        Password::shouldReceive('reset')
            ->once()
            ->withSomeOfArgs([
                'email' => $this->user->email,
                'password' => $password,
                'password_confirmation' => $password,
                'token' => $this->token,
            ])
            ->andReturn(Password::PASSWORD_RESET);

        $request = ResetPasswordFormRequest::factory()->create([
            'email' => $this->user->email,
            'password' => $password,
            'password_confirmation' => $password,
            'token' => $this->token,
        ]);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('login.page'));
    }
}
