<?php

namespace Support\Logging\Telegram;

use Monolog\Logger;

class TelegramLogFactory
{
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('telegram');
        $logger->pushHandler(new TelegramLogHandler($config));
        return $logger;
    }
}
