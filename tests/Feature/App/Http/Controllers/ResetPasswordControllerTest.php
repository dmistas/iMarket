<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Requests\ResetPasswordFormRequest;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{



    public function test_reset_password_success()
    {
        Event::fake();
        $user = UserFactory::new()->create([
            'email' => 'test@mail.ru',
        ]);
        $token = Password::createToken($user);

        $request = ResetPasswordFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $user->password,
            'password_confirmation' => $user->password,
            'token' => $token,
        ]);

        $response = $this->post(action([ResetPasswordController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirect(route('login.page'));

        Event::assertDispatched(PasswordReset::class);

    }

}
