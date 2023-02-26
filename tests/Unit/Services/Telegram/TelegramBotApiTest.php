<?php

namespace Tests\Unit\Services\Telegram;

use Illuminate\Support\Facades\Http;
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
}
