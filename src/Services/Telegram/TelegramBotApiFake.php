<?php


namespace Services\Telegram;


class TelegramBotApiFake extends TelegramBotApi
{
    protected static bool $success = true;

    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        return static::$success;
    }

    public function returnTrue(): static
    {
        static::$success = true;

        return $this;
    }

    public function returnFalse(): static
    {
        static::$success = false;

        return $this;
    }
}
