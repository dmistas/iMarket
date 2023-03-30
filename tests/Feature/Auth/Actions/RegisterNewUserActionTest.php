<?php

namespace Tests\Feature\Auth\Actions;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    public function test_it_success_user_created(): void
    {
        $action = app(RegisterNewUserContract::class);

        $this->assertDatabaseMissing('users', ['email' => 'test@mail.ru']);

        $action(NewUserDTO::make('test', 'test@mail.ru', '123456789'));

        $this->assertDatabaseHas('users', ['email' => 'test@mail.ru']);
    }
}
