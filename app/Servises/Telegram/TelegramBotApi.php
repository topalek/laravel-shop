<?php

namespace App\Servises\Telegram;

use Illuminate\Support\Facades\Http;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $message): void
    {
        try {
            Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text'    => $message
            ]);
        } catch (\Throwable $e) {
        }
    }
}
