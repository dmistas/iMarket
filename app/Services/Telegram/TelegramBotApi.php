<?php

namespace App\Services\Telegram;

use App\Exceptions\TelegramBotApiException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $message)
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $message,
            ]);
            if ($response->status() != Response::HTTP_OK) {
                throw new TelegramBotApiException('Telegram service not response');
            }
        } catch (TelegramBotApiException$e) {
            report($e);
            return false;
        }
    }
}
