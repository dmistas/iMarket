<?php

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    protected int $chatId;
    protected string $token;

    public function __construct($config)
    {
        $this->chatId = (int) $config['chat_id'];
        $this->token = $config['token'];

        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level);
    }

    protected function write(array $record): void
    {
        app(TelegramBotApiContract::class)::sendMessage($this->token, $this->chatId, $record['formatted']);
    }
}
