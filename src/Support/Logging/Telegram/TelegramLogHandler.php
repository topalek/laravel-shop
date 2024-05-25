<?php

namespace Support\Logging\Telegram;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Services\Telegram\TelegramBotApiContract;

final class TelegramLogHandler extends AbstractProcessingHandler
{
    protected $chatId;
    protected $token;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);
        parent::__construct($level);
        $this->chatId = (int)$config['chat_id'];
        $this->token = $config['token'];
    }

    protected function write(LogRecord $record): void
    {
        app(TelegramBotApiContract::class)::sendMessage(
            $this->token,
            $this->chatId,
            $record->formatted
        );
    }
}
