<?php

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Services\Telegram\TelegramBotApiContract;
use Tests\TestCase;
use Services\Telegram\TelegramBotApi;

class TelegramBotApiTest extends TestCase
{

    public function test_is_send_message_success()
    {
        Http::fake([
            TelegramBotApi::HOST . '*' => Http::response(['ok' => true])
        ]);

        $result = TelegramBotApi::sendMessage('', 1, 'Testing message');

        $this->assertTrue($result);
    }

    public function test_is_send_message_success_by_fake_instance()
    {
        TelegramBotApi::fake()
            ->returnTrue();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing message');

        $this->assertTrue($result);
    }

    public function test_is_send_message_fail_by_fake_instance()
    {
        TelegramBotApi::fake()
            ->returnFalse();

        $result = app(TelegramBotApiContract::class)::sendMessage('', 1, 'Testing message');

        $this->assertFalse($result);
    }


}
