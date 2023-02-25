<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\Auth\SignInController;
use App\Http\Requests\SignInFormRequest;
use Database\Factories\UserFactory;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    public function test_it_login_page_success()
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_sign_in_success()
    {
        $password = '123456789';

        $user = UserFactory::new()->create([
            'password' => bcrypt($password),
            'email' => 'test@mail.ru',
        ]);

        $request = SignInFormRequest::factory()
            ->create([
                'email' => $user->email,
                'password' => $password,
            ]);
        $response = $this->post(action([SignInController::class, 'handle']), $request);

        $response->assertValid()
            ->assertRedirectToRoute('home');

        $this->assertAuthenticatedAs($user);

    }

    public function test_logout_success()
    {
        $user = UserFactory::new()->create([
            'email' => 'test@mail.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logout']));

        $this->assertGuest();
    }

}
