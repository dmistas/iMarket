<?php

namespace Tests\Feature\Auth\DTOs;

use App\Http\Requests\SignUpFormRequest;
use Domain\Auth\DTOs\NewUserDTO;
use Tests\TestCase;

class NewUserDTOTest extends TestCase
{
    public function test_instance_created_from_form_request(): void
    {
        $dto = NewUserDTO::fromRequest(new SignUpFormRequest([
            'name' => 'test',
            'email' => 'test@mail.ru',
            'password' => '1234567890',
        ]));

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }

    public function test_instance_created_with_make(): void
    {
        $dto = NewUserDTO::make('test', 'test@mail.ru', '1234567890');

        $this->assertInstanceOf(NewUserDTO::class, $dto);
    }
}
